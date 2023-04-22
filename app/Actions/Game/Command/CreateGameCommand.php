<?php

namespace App\Actions\Game\Command;

/**
 * @property $localTeamId
 * @property $awayTeamId
 * @property $dateStartGame
 * @property $competitionPhaseId
 */
class CreateGameCommand
{
    public function __construct(
        public int $competitionPhaseId,
        public int $localTeamId,
        public int $awayTeamId,
        public string $dateStartGame
    )
    {
    }

}
