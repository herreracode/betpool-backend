<?php

namespace App\Actions\Game;

use App\Models\Game;

/**
 * Class GetGamesActionByCriteria
 */
class GetGamesActionByCriteria
{
    public function __invoke(
        GetGameByCriteriaQuery $GetGameByCriteriaQuery
    ) {

        $QueryBuilder = Game::query();

        if($GetGameByCriteriaQuery->competitionPhaseId)
            $QueryBuilder->where('competition_phase_id',$GetGameByCriteriaQuery->competitionPhaseId);

        return $QueryBuilder->get();
    }
}
