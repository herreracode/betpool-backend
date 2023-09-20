<?php

namespace App\Queries\Prediction\Filters;

use App\Queries\Common\Filter;
use Closure;

/**
 * Class PoolFilter
 */
class PoolRoundFilter implements Filter
{
    public function handle($request, Closure $next)
    {
        $request->QueryBuilder;
        $GetPredictionByCriteriaQuery = $request->GetPredictionByCriteriaQuery;

        if (! $GetPredictionByCriteriaQuery->pool_round_id) {
            return $next($request);
        }

        $request->QueryBuilder->where('pool_round_id', $GetPredictionByCriteriaQuery->pool_round_id);

        return $next($request);
    }
}
