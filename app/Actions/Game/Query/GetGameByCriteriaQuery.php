<?php

namespace App\Actions\Game\Query;

/**
 * Class GetGamesActionByCriteria
 */
class GetGameByCriteriaQuery
{
    public function __construct(public int $competitionPhaseId)
    {
    }
}
