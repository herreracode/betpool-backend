<?php

namespace App\Actions\Game;

use App\Models\Competition;
use App\Models\CompetitionPhase;
use App\Models\Game;
use App\Models\Team;
use Exception;

/**
 * Class CreateGame
 */
class CreateGame
{

    public function __invoke(
           CompetitionPhase $CompetitionPhase,
           Team $LocalTeam,
           Team $AwayTeam
    )
    {
        $Game = $CompetitionPhase->games()->create([
             'local_team_id' => $LocalTeam->id,
             'away_team_id' => $AwayTeam->id,
        ]);

        if(!$Game)
            throw new Exception("dont save Game");

        return $Game;
    }
}
