<?php

namespace App\Queries\Prediction\Filters;

use App\Queries\Common\Filter;
use Closure;

/**
 * Class UserFilter
 */
class UserFilter implements Filter
{
    public function handle($request, Closure $next)
    {
        $request->QueryBuilder;
        $GetPredictionByCriteriaQuery = $request->GetPredictionByCriteriaQuery;

        if (! $GetPredictionByCriteriaQuery->user_id) {
            return $next($request);
        }

        $request->QueryBuilder->where('user_id', $GetPredictionByCriteriaQuery->user_id);

        return $next($request);
    }
}
