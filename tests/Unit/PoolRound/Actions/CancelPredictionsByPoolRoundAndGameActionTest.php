<?php

namespace PoolRound\Actions;

use App\Actions\PoolRound\CancelPredictionsByPoolRoundAndGame;
use App\Actions\PoolRound\ClosePredictionsByPoolRoundAndGame;
use App\Models\Competition;
use App\Models\CompetitionPhase;
use App\Models\Game;
use App\Models\Pool;
use App\Models\PoolRound;
use App\Models\Prediction;
use App\Models\Score;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CancelPredictionsByPoolRoundAndGameActionTest extends TestCase
{
    use RefreshDatabase;
    use WithoutEvents;

    protected function setUp(): void
    {
        parent::setup();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        $this->CancelPredictionsByPoolRoundAndGame = app(CancelPredictionsByPoolRoundAndGame::class);
        $this->ClosePredictionsByPoolRoundAndGame = app(ClosePredictionsByPoolRoundAndGame::class);
    }

    /**
     *
     * @return void
     */
    public function testCreatePoolRoundAndAllGamesIsPostPoned()
    {

        /**
         * @var User $UserCreator
         */
        $UserCreator = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $UserCreator = Sanctum::actingAs(
            $UserCreator,
            ['*']
        );

        $Pool = Pool::factory()->create();

        $UserCreator->addRoleUserCreatorByPool($Pool);

        $Competition = Competition::factory();

        $CompetitionPhase = CompetitionPhase::factory()->for($Competition);

        $Games = Game::factory(3)
            ->for($CompetitionPhase)
            ->inPostpone()
            ->create();

        $PoolRound = PoolRound::factory()
            ->for($Pool)
            ->hasAttached($Games)
            ->create();

        $Games->each(
            function (Game $Game) use ($UserCreator, $Pool, $PoolRound) {

                $Prediction = Prediction::factory()
                    ->for($UserCreator)
                    ->for($Pool)
                    ->for($PoolRound)
                    ->for($Game)
                    ->inPending()
                    ->create();

                Score::factory([
                    'local_team_score' => 0,
                    'away_team_score' => 1,
                    'scorable_type' => $Prediction::class,
                    'scorable_id' => $Prediction->id,
                ])->create();
            }
        );

        $Games->each(
            function (Game $Game) use ($PoolRound) {

                $PoolRound = $this
                    ->CancelPredictionsByPoolRoundAndGame
                    ->__invoke($PoolRound, $Game);
            }
        );

        $this->assertInstanceOf(PoolRound::class, $PoolRound);

        //PoolRound finish
        $this->assertEquals($PoolRound->status, '_FINISH_');
    }

    public function testCreatePoolRoundAndAllGamesNotPostponed()
    {

        /**
         * @var User $UserCreator
         */
        $UserCreator = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $UserCreator = Sanctum::actingAs(
            $UserCreator,
            ['*']
        );

        $Pool = Pool::factory()->create();

        $UserCreator->addRoleUserCreatorByPool($Pool);

        $Competition = Competition::factory();

        $CompetitionPhase = CompetitionPhase::factory()->for($Competition);

        $GamesPostpone = Game::factory(3)
            ->for($CompetitionPhase)
            ->inPostpone()
            ->create();

        //add game not finished
        $GamePending = Game::factory()
            ->for($CompetitionPhase)
            ->inPending()
            ->create();

        $GamesPostpone->each(
            fn(Game $Game) =>
            Score::factory([
                'local_team_score' => 3,
                'away_team_score' => 0,
                'scorable_type' => $Game::class,
                'scorable_id' => $Game->id
            ])->create()
        );

        $PoolRound = PoolRound::factory()
            ->for($Pool)
            ->hasAttached($GamesPostpone)
            ->hasAttached($GamePending)
            ->create()->refresh();

        $GamesPostpone->each(
            function (Game $Game) use ($UserCreator, $Pool, $PoolRound) {

                $Prediction = Prediction::factory()
                    ->for($UserCreator)
                    ->for($Pool)
                    ->for($PoolRound)
                    ->for($Game)
                    ->inPending()
                    ->create();

                Score::factory([
                    'local_team_score' => 0,
                    'away_team_score' => 1,
                    'scorable_type' => $Prediction::class,
                    'scorable_id' => $Prediction->id,
                ])->create();
            }
        );

        $PredictionGamePending = Prediction::factory()
            ->for($UserCreator)
            ->for($Pool)
            ->for($PoolRound)
            ->for($GamePending)
            ->inPending()
            ->create();

        Score::factory([
            'local_team_score' => 0,
            'away_team_score' => 1,
            'scorable_type' => $PredictionGamePending::class,
            'scorable_id' => $PredictionGamePending->id,
        ])->create();


        $GamesPostpone->each(
            function (Game $Game) use ($PoolRound) {

                $PoolRound = $this
                    ->CancelPredictionsByPoolRoundAndGame
                    ->__invoke($PoolRound, $Game);
            }
        );

        $this->assertInstanceOf(PoolRound::class, $PoolRound);

        //PoolRound _PENDING_
        $this->assertEquals($PoolRound->status, '_PENDING_');
    }

    public function testCreatePoolRoundAndAllGamesPostponedAndFinish()
    {

        /**
         * @var User $UserCreator
         */
        $UserCreator = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $UserCreator = Sanctum::actingAs(
            $UserCreator,
            ['*']
        );

        $Pool = Pool::factory()->create();

        $UserCreator->addRoleUserCreatorByPool($Pool);

        $Competition = Competition::factory();

        $CompetitionPhase = CompetitionPhase::factory()->for($Competition);

        $GamesFinished = Game::factory(3)
            ->for($CompetitionPhase)
            ->inFinish()
            ->create();

        //add game not finished
        $GamePostpone = Game::factory()
            ->for($CompetitionPhase)
            ->inPostpone()
            ->create();

        $GamesFinished->each(
            fn(Game $Game) =>
            Score::factory([
                'local_team_score' => 3,
                'away_team_score' => 0,
                'scorable_type' => $Game::class,
                'scorable_id' => $Game->id
            ])->create()
        );

        $PoolRound = PoolRound::factory()
            ->for($Pool)
            ->hasAttached($GamesFinished)
            ->hasAttached($GamePostpone)
            ->create()->refresh();

        $GamesFinished->each(
            function (Game $Game) use ($UserCreator, $Pool, $PoolRound) {

                $Prediction = Prediction::factory()
                    ->for($UserCreator)
                    ->for($Pool)
                    ->for($PoolRound)
                    ->for($Game)
                    ->inPending()
                    ->create();

                Score::factory([
                    'local_team_score' => 0,
                    'away_team_score' => 1,
                    'scorable_type' => $Prediction::class,
                    'scorable_id' => $Prediction->id,
                ])->create();
            }
        );

        $GamesFinished->each(
            function (Game $Game) use ($PoolRound) {

                $PoolRound = $this->ClosePredictionsByPoolRoundAndGame
                    ->__invoke($PoolRound, $Game);
            }
        );

        $PoolRound = $this
            ->CancelPredictionsByPoolRoundAndGame
            ->__invoke($PoolRound, $GamePostpone);

        $this->assertInstanceOf(PoolRound::class, $PoolRound);

        //PoolRound _PENDING_
        $this->assertEquals($PoolRound->status, '_FINISH_');
    }

}
