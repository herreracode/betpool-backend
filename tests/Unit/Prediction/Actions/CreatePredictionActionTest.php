<?php

namespace Prediction\Actions;

use App\Actions\Prediction\CreatePrediction;
use App\Exceptions\Pool\UserDoesntBelongToThePool;
use App\Exceptions\Prediction\GameIsAboutToStart;
use App\Exceptions\Prediction\GameIsNotStateValid;
use App\Models\Competition;
use App\Models\CompetitionPhase;
use App\Models\Game;
use App\Models\Pool;
use App\Models\PoolRound;
use App\Models\Prediction;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreatePredictionActionTest extends TestCase
{
    use RefreshDatabase;
    use WithoutEvents;

    const TIME_IN_MINUTES_TO_EXPIRED_PERIOD = 30;

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

        $PoolRound = PoolRound::factory()
            ->for($Pool)
            ->create();

        $timeInMinutesToExpiredPeriod = 31;

        $dateCreatePrediction = new \DateTime();

        $nowTimeStampAddTime = (new \DateTime())
            ->modify("+{$timeInMinutesToExpiredPeriod} minutes")
            ->modify("+2 days");

        $Game = Game::factory([
            'date_start' => $nowTimeStampAddTime
        ])
            ->inPending()
            ->for(CompetitionPhase::factory()
                ->for(Competition::factory()))
            ->create();

        $localTeamScore = rand(1,7);

        $awayTeamScore = rand(1,7);

        $Prediction = $this->CreatePredictionAction->__invoke(
            User : $User,
            Pool : $Pool,
            Game : $Game,
            PoolRound: $PoolRound,
            localTeamScore : $localTeamScore,
            awayTeamScore : $awayTeamScore,
            dateCreatePrediction : $dateCreatePrediction
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

        $PoolRound = PoolRound::factory()
            ->for($Pool)
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
            $PoolRound,
            $localTeamScore,
            $awayTeamScore,
        );
    }

    public function testThrowExceptionWhenGameIsNotInPending()
    {
        $this->expectException(GameIsNotStateValid::class);

        $User = User::factory()->create();

        $Pool = Pool::factory()
            ->hasAttached($User)
            ->create();

        $PoolRound = PoolRound::factory()
            ->for($Pool)
            ->create();

        $Game = Game::factory()
            ->inProgress()
            ->for(CompetitionPhase::factory()
                ->for(Competition::factory()))
            ->create();

        $localTeamScore = rand(1,7);

        $awayTeamScore = rand(1,7);

        $this->CreatePredictionAction->__invoke(
            $User,
            $Pool,
            $Game,
            $PoolRound,
            $localTeamScore,
            $awayTeamScore,
        );
    }

    public function testThrowExceptionWhenUserHavePredictionInThisGameAndPool()
    {

    }

    public function testThrowExceptionWhenPeriodToCreatePredictionHasExpiredBeforeTheGame()
    {
        $this->expectException(GameIsAboutToStart::class);

        $timeInMinutesToExpiredPeriod = static::TIME_IN_MINUTES_TO_EXPIRED_PERIOD - 2;

        $User = User::factory()->create();

        $Pool = Pool::factory()
            ->hasAttached($User)
            ->create();

        $PoolRound = PoolRound::factory()
            ->for($Pool)
            ->create();

        $localTeamScore = rand(1, 7);

        $awayTeamScore = rand(1, 7);

        $dateCreatePrediction = new \DateTime();

        $nowTimeStampAddTimeToExpired = (new \DateTime())
            ->modify("+{$timeInMinutesToExpiredPeriod} minutes");

        $Game = Game::factory([
            'date_start' => $nowTimeStampAddTimeToExpired
        ])->inPending()
            ->for(CompetitionPhase::factory()
                ->for(Competition::factory()))
            ->create();

        $this->CreatePredictionAction->__invoke(
            User : $User,
            Pool : $Pool,
            Game : $Game,
            PoolRound :$PoolRound,
            localTeamScore : $localTeamScore,
            awayTeamScore : $awayTeamScore,
            dateCreatePrediction : $dateCreatePrediction
        );
    }

    public function testThrowExceptionWhenPeriodToCreatePredictionExceededAllowedTime()
    {
        $this->expectException(GameIsAboutToStart::class);

        $timeInDaysToExceeded = 1;

        $User = User::factory()->create();

        $Pool = Pool::factory()
            ->hasAttached($User)
            ->create();

        $PoolRound = PoolRound::factory()
            ->for($Pool)
            ->create();

        $localTeamScore = rand(1, 7);

        $awayTeamScore = rand(1, 7);

        $nowTimeStampAddDaysToExceeded = new \DateTime();

        $dateCreatePrediction = (new \DateTime())
            ->modify("+{$timeInDaysToExceeded} days");

        $Game = Game::factory([
            'date_start' => $nowTimeStampAddDaysToExceeded
        ])->inPending()
            ->for(CompetitionPhase::factory()
                ->for(Competition::factory()))
            ->create();

        $this->CreatePredictionAction->__invoke(
            User : $User,
            Pool : $Pool,
            Game : $Game,
            PoolRound :$PoolRound,
            localTeamScore : $localTeamScore,
            awayTeamScore : $awayTeamScore,
            dateCreatePrediction : $dateCreatePrediction
        );
    }
}
