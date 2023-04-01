<?php

namespace App\DomainServices\Prediction;

use App\Models\Game;
use App\Models\Prediction;

class CalculateNumberOfPointsEarned
{
    protected const POINT_HIT_EXACT_RESULT = 12;
    protected const HIT_GAME_WINNER_AND_NUMBER_GOALS_ONE_TEAM = 7;
    protected const HIT_GAME_RESULT_NOT_EXACT = 5;
    protected const HIT_NUMBER_SCORE_ONE_TEAM = 2;

    protected const NOT_HIT_ANYTHING = 0;

    public function __invoke(
            Prediction $Prediction,
            Game $Game
    ): int
    {
        $isEqualLocalScoreTeam = $Prediction->getLocalTeamScore() == $Game->getLocalTeamScore();

        $isEqualAwayScoreTeam = $Prediction->getAwayTeamScore() == $Game->getAwayTeamScore();

        if($isEqualLocalScoreTeam && $isEqualAwayScoreTeam)
            return static::POINT_HIT_EXACT_RESULT;

        $hitAtLeastOneResult = $isEqualLocalScoreTeam || $isEqualAwayScoreTeam;

        $hitResultGame = $Prediction->getTeamWinner()?->id == $Game->getTeamWinner()?->id;

        if($hitResultGame && $hitAtLeastOneResult)
            return static::HIT_GAME_WINNER_AND_NUMBER_GOALS_ONE_TEAM;

        if($hitResultGame)
            return static::HIT_GAME_RESULT_NOT_EXACT;

        if($hitAtLeastOneResult)
            return static::HIT_NUMBER_SCORE_ONE_TEAM;

        return static::NOT_HIT_ANYTHING;
    }
}
