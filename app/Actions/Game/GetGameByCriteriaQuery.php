<?php

namespace App\Actions\Game;

/**
 * Class GetGamesActionByCriteria
 */
class GetGameByCriteriaQuery
{
    public function __construct(public int $competitionPhaseId)
    {
    }
}
