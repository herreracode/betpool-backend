<?php

namespace Prediction\Actions;

use App\Actions\Prediction\ClosePrediction;
use App\Actions\Prediction\CreatePrediction;
use App\Exceptions\Pool\UserDoesntBelongToThePool;
use App\Exceptions\Prediction\GameIsAboutToStart;
use App\Exceptions\Prediction\GameIsNotFinishedToClosePrediction;
use App\Exceptions\Prediction\GameIsNotStateValid;
use App\Models\Competition;
use App\Models\CompetitionPhase;
use App\Models\Game;
use App\Models\Pool;
use App\Models\Prediction;
use App\Models\Score;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Tests\TestCase;

class ClosePredictionActionTest extends TestCase
{
    use RefreshDatabase;
    use WithoutEvents;

    const POINT_HIT_EXACT_RESULT = 12;

    protected function setUp(): void
    {
        parent::setup();

        $this->ClosePredictionAction = app(ClosePrediction::class);
    }

    public function testClosePredictionHappyPath()
    {
        $Competition = Competition::factory();

        $CompetitionPhase = CompetitionPhase::factory()->for($Competition);

        $Game = Game::factory()
            ->inFinish()
            ->for($CompetitionPhase)
            ->create();

        Score::factory([
            'local_team_score' => 3,
            'away_team_score' => 0,
            'scorable_type' => $Game::class,
            'scorable_id' => $Game->id
        ])->create();

        $User = User::factory()->create();

        $Pool = Pool::factory()
            ->hasAttached($User)
            ->hasAttached($Competition)
            ->create();

        $Prediction = Prediction::factory()
            ->for($User)
            ->for($Pool)
            ->for($Game)
            ->inPending()
            ->create();



        Score::factory([
            'local_team_score' => 0,
            'away_team_score' => 1,
            'scorable_type' => $Prediction::class,
            'scorable_id' => $Prediction->id,
        ])->create();

        $this->ClosePredictionAction->__invoke(
            $Prediction
        );

        $this->assertTrue($Prediction->itIsInClose());
        $this->assertNotEmpty($Prediction->points_earned == 0 || $Prediction->points_earned > 0 );
    }

    public function testThrowExepctionWhenGameIsNotFinished()
    {
        $this->expectException(GameIsNotFinishedToClosePrediction::class);

        $Competition = Competition::factory();

        $CompetitionPhase = CompetitionPhase::factory()->for($Competition);

        $Game = Game::factory()
            ->inProgress()
            ->for($CompetitionPhase)
            ->create();

        Score::factory([
            'local_team_score' => 3,
            'away_team_score' => 0,
            'scorable_type' => $Game::class,
            'scorable_id' => $Game->id
        ])->create();

        $User = User::factory()->create();

        $Pool = Pool::factory()
            ->hasAttached($User)
            ->hasAttached($Competition)
            ->create();

        $Prediction = Prediction::factory()
            ->for($User)
            ->for($Pool)
            ->for($Game)
            ->inPending()
            ->create();

        Score::factory([
            'local_team_score' => 0,
            'away_team_score' => 1,
            'scorable_type' => $Prediction::class,
            'scorable_id' => $Prediction->id,
        ])->create();

        $this->ClosePredictionAction->__invoke(
            $Prediction
        );
    }


}
