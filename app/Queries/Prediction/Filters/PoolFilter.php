<?php

namespace App\Queries\Prediction\Filters;

use App\Queries\Common\Filter;
use Closure;

/**
 * Class PoolFilter
 */
class PoolFilter implements Filter
{
    public function handle($request, Closure $next)
    {
        $request->QueryBuilder;
        $GetPredictionByCriteriaQuery = $request->GetPredictionByCriteriaQuery;

        if (! $GetPredictionByCriteriaQuery->pool_id) {
            return $next($request);
        }

        $request->QueryBuilder->where('pool_id', $GetPredictionByCriteriaQuery->pool_id);

        return $next($request);
    }
}
