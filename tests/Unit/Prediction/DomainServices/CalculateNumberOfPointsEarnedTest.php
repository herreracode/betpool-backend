<?php

namespace Prediction\DomainServices;

use App\DomainServices\Prediction\CalculateNumberOfPointsEarned;
use App\Models\Competition;
use App\Models\CompetitionPhase;
use App\Models\Game;
use App\Models\Pool;
use App\Models\Prediction;
use App\Models\Score;
use App\Models\User;
use Tests\TestCase;

class CalculateNumberOfPointsEarnedTest extends TestCase
{

    protected const POINT_HIT_EXACT_RESULT = 12;

    protected const HIT_GAME_WINNER_AND_NUMBER_GOALS = 7;

    protected const HIT_GAME_RESULT_NOT_EXACT = 5;

    protected const HIT_NUMBER_SCORE_ONE_TEAM = 2;

    protected const NOT_HIT_ANYTHING = 0;

    protected function setUp(): void
    {
        parent::setup();

        $this->CalculateNumberOfPointsEarned = app(CalculateNumberOfPointsEarned::class);
    }

    /**
     * @inheritDoc
     */
    public function testCalculatePointsEarnedHitExactResult()
    {
        $localTeamScore = rand(1,9);

        $AwayTeamScore = rand(1,9);

        $Competition = Competition::factory();

        $CompetitionPhase = CompetitionPhase::factory()->for($Competition);

        $Game = Game::factory()
            ->inProgress()
            ->for($CompetitionPhase)
            ->create();

        Score::factory([
            'local_team_score' => $localTeamScore,
            'away_team_score' => $AwayTeamScore,
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
            'local_team_score' => $localTeamScore,
            'away_team_score' => $AwayTeamScore,
            'scorable_type' => $Prediction::class,
            'scorable_id' => $Prediction->id,
        ])->create();

        $pointsEarned = $this->CalculateNumberOfPointsEarned->__invoke(
            $Prediction,
            $Game
        );

        $this->assertTrue($pointsEarned == static::POINT_HIT_EXACT_RESULT);
    }

    /**
     * @inheritDoc
     */
    public function testCalculatePointsEarnedHitGameWinnerAndNumberGoalsOf1Team()
    {
        $Competition = Competition::factory();

        $CompetitionPhase = CompetitionPhase::factory()->for($Competition);

        $Game = Game::factory()
            ->inProgress()
            ->for($CompetitionPhase)
            ->create();

        Score::factory([
            'local_team_score' => 3,
            'away_team_score' => 1,
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
            'local_team_score' => 3,
            'away_team_score' => 2,
            'scorable_type' => $Prediction::class,
            'scorable_id' => $Prediction->id,
        ])->create();

        $pointsEarned = $this->CalculateNumberOfPointsEarned->__invoke(
            $Prediction,
            $Game
        );

        $this->assertTrue($pointsEarned == static::HIT_GAME_WINNER_AND_NUMBER_GOALS);
    }

    public function testCalculatePointsEarnedHitGameWinner()
    {
        $Competition = Competition::factory();

        $CompetitionPhase = CompetitionPhase::factory()->for($Competition);

        $Game = Game::factory()
            ->inProgress()
            ->for($CompetitionPhase)
            ->create();

        Score::factory([
            'local_team_score' => 1,
            'away_team_score' => 1,
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
            'local_team_score' => 2,
            'away_team_score' => 2,
            'scorable_type' => $Prediction::class,
            'scorable_id' => $Prediction->id,
        ])->create();

        $pointsEarned = $this->CalculateNumberOfPointsEarned->__invoke(
            $Prediction,
            $Game
        );

        $this->assertTrue($pointsEarned == static::HIT_GAME_RESULT_NOT_EXACT);
    }

    public function testCalculatePointsEarnedHitNumberScoreOneTeam()
    {
        $Competition = Competition::factory();

        $CompetitionPhase = CompetitionPhase::factory()->for($Competition);

        $Game = Game::factory()
            ->inProgress()
            ->for($CompetitionPhase)
            ->create();

        Score::factory([
            'local_team_score' => 2,
            'away_team_score' => 1,
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

        $pointsEarned = $this->CalculateNumberOfPointsEarned->__invoke(
            $Prediction,
            $Game
        );

        $this->assertTrue($pointsEarned == static::HIT_NUMBER_SCORE_ONE_TEAM);
    }

    public function testCalculatePointsEarnedNotHitAnything()
    {
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

        $pointsEarned = $this->CalculateNumberOfPointsEarned->__invoke(
            $Prediction,
            $Game
        );

        $this->assertTrue($pointsEarned == static::NOT_HIT_ANYTHING);
    }
}
