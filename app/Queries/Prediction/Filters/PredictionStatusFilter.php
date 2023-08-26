<?php

namespace App\Queries\Prediction\Filters;

use App\Queries\Common\Filter;
use Closure;

/**
 * Class PredictionStatusFilter
 */
class PredictionStatusFilter implements Filter
{
    public function handle($request, Closure $next)
    {
        $request->QueryBuilder;
        $GetPredictionByCriteriaQuery = $request->GetPredictionByCriteriaQuery;

        if (! $GetPredictionByCriteriaQuery->prediction_status) {
            return $next($request);
        }

        $request
        ->QueryBuilder
        ->where('predictions.status', $GetPredictionByCriteriaQuery->prediction_status);

        return $next($request);
    }
}
