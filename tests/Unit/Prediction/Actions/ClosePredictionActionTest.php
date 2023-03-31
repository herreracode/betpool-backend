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
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Tests\TestCase;

class ClosePredictionActionTest extends TestCase
{
    use RefreshDatabase;
    use WithoutEvents;

    const TIME_IN_MINUTES_TO_EXPIRED_PERIOD = 30;

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

        $User = User::factory()->create();

        $Pool = Pool::factory()
            ->hasAttached($User)
            ->hasAttached($Competition)
            ->create();

        $Prediction = Prediction::factory()
            ->for($User)
            ->for($Pool)
            ->for($Game)
            ->create();

        $this->ClosePredictionAction->__invoke(
            $Prediction
        );

        $this->assertTrue($Prediction->itIsInClose());
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

        $User = User::factory()->create();

        $Pool = Pool::factory()
            ->hasAttached($User)
            ->hasAttached($Competition)
            ->create();

        $Prediction = Prediction::factory()
            ->for($User)
            ->for($Pool)
            ->for($Game)
            ->create();

        $this->ClosePredictionAction->__invoke(
            $Prediction
        );
    }


}
