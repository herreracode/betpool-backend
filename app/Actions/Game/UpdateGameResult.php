<?php

namespace App\Actions\Game;

use App\Models\Game;
use App\Models\Score;
use Exception;

/**
 * Class CreateGame
 */
class UpdateGameResult
{
    public function __invoke(
           Game $Game,
           int $localTeamScore,
           int $awayTeamScore,
    ): Score {
        $Score = $Game->score()->create([
            'local_team_score' => $localTeamScore,
            'away_team_score' => $awayTeamScore,
        ]);

        if (! $Score) {
            throw new Exception('dont create Score');
        }

        return $Score;
    }
}
