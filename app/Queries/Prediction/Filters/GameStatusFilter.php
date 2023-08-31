<?php

namespace App\Queries\Prediction\Filters;

use App\Queries\Common\Filter;
use Closure;

/**
 * Class UserNotFilter
 */
class GameStatusFilter implements Filter
{
    public function handle($request, Closure $next)
    {
        $request->QueryBuilder;
        $GetPredictionByCriteriaQuery = $request->GetPredictionByCriteriaQuery;

        if (! $GetPredictionByCriteriaQuery->game_status) {
            return $next($request);
        }

        $request
        ->QueryBuilder
        ->join('games', 'games.id', '=', 'predictions.game_id')
        ->where('games.status', $GetPredictionByCriteriaQuery->game_status);

        return $next($request);
    }
}
