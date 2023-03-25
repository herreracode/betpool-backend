<?php

namespace App\Actions\Game;

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
    ): Game
    {
        return $CompetitionPhase->addGame($LocalTeam, $AwayTeam);
    }
}
