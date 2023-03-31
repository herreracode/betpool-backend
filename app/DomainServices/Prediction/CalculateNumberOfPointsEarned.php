<?php

namespace App\DomainServices\Prediction;

use App\Models\Game;
use App\Models\Prediction;

class CalculateNumberOfPointsEarned
{
    protected const POINT_HIT_EXACT_RESULT = 12;
    protected const HIT_GAME_WINNER_AND_NUMBER_GOALS = 7;

    public function __invoke(
            Prediction $Prediction,
            Game $Game
    ): int
    {
        $ScorePrediction = $Prediction->score;

        $ScoreGame = $Game->score;

        $isEqualLocalScoreTeam = $ScorePrediction->local_team_score == $ScoreGame->local_team_score;

        $isEqualAwayScoreTeam = $ScorePrediction->away_team_score == $ScoreGame->away_team_score;

        if($isEqualLocalScoreTeam && $isEqualAwayScoreTeam)
            return static::POINT_HIT_EXACT_RESULT;

        $gameWinner = $ScoreGame->local_team_score > $ScoreGame->away_team_score
            ? 'local_team_score'
            : 'away_team_score';

        $predictionWinner = $ScorePrediction->local_team_score > $ScorePrediction->away_team_score
            ? 'local_team_score'
            : 'away_team_score';

        $hitGameWinner = $gameWinner == $predictionWinner;

        if($hitGameWinner && ($isEqualLocalScoreTeam || $isEqualAwayScoreTeam))
            return static::HIT_GAME_WINNER_AND_NUMBER_GOALS;

        return 0;
    }
}
