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
    /**
     * @param Game $Game
     * @param int $localTeamScore
     * @param int $awayTeamScore
     * @return Score
     * @throws Exception
     */
    public function __invoke(
           Game $Game,
           int $localTeamScore,
           int $awayTeamScore,
    ): Score {
        return $Game->updateGameResult($localTeamScore, $awayTeamScore);
    }
}
