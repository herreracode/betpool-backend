<?php

namespace App\Actions\Game\Query\Filters;

use Closure;

/**
 * Class CompetitionPhaseFilter
 */
class CompetitionPhaseFilter
{
    public function handle($request, Closure $next)
    {
        $request->QueryBuilder;
        $GetGameByCriteriaQuery = $request->GetGameByCriteriaQuery;

        if (! $GetGameByCriteriaQuery->competitionPhaseId) {
            return $next($request);
        }

        return $next($request)->QueryBuilder->where('competition_phase_id', $GetGameByCriteriaQuery->competitionPhaseId);
    }
}
