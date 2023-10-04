<?php

namespace Prediction\Actions;

use App\Actions\Prediction\ModifyPrediction;
use App\Exceptions\Prediction\GameIsNotStateValid;
use App\Exceptions\Prediction\UserModifierNotOwner;
use App\Models\Competition;
use App\Models\CompetitionPhase;
use App\Models\Game;
use App\Models\Pool;
use App\Models\PoolRound;
use App\Models\Prediction;
use App\Models\Score;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Tests\TestCase;
use App\Models\User;

class ModifyPredictionActionTest extends TestCase
{

    use RefreshDatabase;
    use WithoutEvents;

    protected function setUp(): void
    {
        parent::setup();

        $this->ModifyPredictionAction = app(ModifyPrediction::class);
    }

    public function testModifyPredictionHappyPath()
    {
        $User = User::factory()->create();

        $idUserModifier = $User->id;

        $Pool = Pool::factory()
            ->hasAttached($User)
            ->create();

        $PoolRound = PoolRound::factory()
            ->for($Pool)
            ->create();

        $timeInMinutesToExpiredPeriod = 60;

        $nowTimeStampAddTime = (new \DateTime())
            ->modify("+{$timeInMinutesToExpiredPeriod} minutes");

        $Game = Game::factory([
            'date_start' => $nowTimeStampAddTime
        ])
            ->inPending()
            ->for(CompetitionPhase::factory()
                ->for(Competition::factory()))
            ->create();

        $scoreLocal = 2;

        $scoreAway = 1;

        $Prediction = Prediction::factory()
            ->for($User)
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

        $this->ModifyPredictionAction->__invoke(
            Prediction: $Prediction,
            scoreLocal: $scoreLocal,
            scoreAway: $scoreAway,
            idUserModifier: $idUserModifier
        );

        $this->assertEquals($scoreLocal, $Prediction->score->local_team_score);

        $this->assertEquals($scoreAway, $Prediction->score->away_team_score);
    }

    public function testThrowExceptionWhenGameIsNotStatePending()
    {
        $this->expectException(GameIsNotStateValid::class);

        $User = User::factory()->create();

        $idUserModifier = $User->id;

        $Pool = Pool::factory()
            ->hasAttached($User)
            ->create();

        $PoolRound = PoolRound::factory()
            ->for($Pool)
            ->create();

        $timeInMinutesToExpiredPeriod = 40;

        $nowTimeStampAddTime = (new \DateTime())
            ->modify("+{$timeInMinutesToExpiredPeriod} minutes");

        $Game = Game::factory([
            'date_start' => $nowTimeStampAddTime
        ])
            ->inProgress()
            ->for(CompetitionPhase::factory()
                ->for(Competition::factory()))
            ->create();

        $scoreLocal = 2;

        $scoreAway = 1;

        $Prediction = Prediction::factory()
            ->for($User)
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

        $this->ModifyPredictionAction->__invoke(
            Prediction: $Prediction,
            scoreLocal: $scoreLocal,
            scoreAway: $scoreAway,
            idUserModifier: $idUserModifier
        );


    }

    public function testThrowExceptionWhenUserModifyIsOwner()
    {
        $this->expectException(UserModifierNotOwner::class);

        $User = User::factory()->create();

        $Pool = Pool::factory()
            ->hasAttached($User)
            ->create();

        $PoolRound = PoolRound::factory()
            ->for($Pool)
            ->create();

        $timeInMinutesToExpiredPeriod = 40;

        $nowTimeStampAddTime = (new \DateTime())
            ->modify("+{$timeInMinutesToExpiredPeriod} minutes");

        $Game = Game::factory([
            'date_start' => $nowTimeStampAddTime
        ])
            ->inPending()
            ->for(CompetitionPhase::factory()
                ->for(Competition::factory()))
            ->create();

        $scoreLocal = 2;

        $scoreAway = 1;

        $Prediction = Prediction::factory()
            ->for($User)
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

        $this->ModifyPredictionAction->__invoke(
            Prediction: $Prediction,
            scoreLocal: $scoreLocal,
            scoreAway: $scoreAway,
            idUserModifier: 899898989
        );


    }

}
