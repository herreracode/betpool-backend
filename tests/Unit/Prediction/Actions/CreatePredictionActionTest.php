<?php

namespace Prediction\Actions;

use App\Actions\Prediction\CreatePrediction;
use App\Exceptions\Pool\UserDoesntBelongToThePool;
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

class CreatePredictionActionTest extends TestCase
{
    use RefreshDatabase;
    use WithoutEvents;

    protected function setUp(): void
    {
        parent::setup();

        $this->CreatePredictionAction = app(CreatePrediction::class);
    }

    public function testCreatePredictionHappyPath()
    {
        $User = User::factory()->create();

        $Pool = Pool::factory()
            ->hasAttached($User)
            ->create();

        $Game = Game::factory()
            ->for(CompetitionPhase::factory()
                ->for(Competition::factory()))
            ->create();

        $localTeamScore = rand(1,7);

        $awayTeamScore = rand(1,7);

        $Prediction = $this->CreatePredictionAction->__invoke(
            $User,
            $Pool,
            $Game,
            $localTeamScore,
            $awayTeamScore,
        );

        $this->assertInstanceOf(Prediction::class, $Prediction);

        $this->assertSame($localTeamScore, $Prediction->getLocalTeamScore());

        $this->assertSame($awayTeamScore, $Prediction->getAwayTeamScore());

        $this->assertSame($Game->id, $Prediction->game->id);
    }

    public function testThrowExceptionWhenUserDoesntBelongToThePool()
    {
        $this->expectException(UserDoesntBelongToThePool::class);

        $User = User::factory()->create();

        $Pool = Pool::factory()
            ->create();

        $Game = Game::factory()
            ->for(CompetitionPhase::factory()
                ->for(Competition::factory()))
            ->create();

        $localTeamScore = rand(1,7);

        $awayTeamScore = rand(1,7);

        $this->CreatePredictionAction->__invoke(
            $User,
            $Pool,
            $Game,
            $localTeamScore,
            $awayTeamScore,
        );
    }

    public function testThrowExceptionWhenGameIsNotInPending()
    {

    }

    public function testThrowExceptionWhenUserHavePredictionInThisGameAndPool()
    {

    }

    public function testThrowExceptionWhenPeriodToCreatePredictionHasExpiredBeforeTheGame()
    {
        $timeInMinutesToExpiredPeriod = 30;


    }
}
