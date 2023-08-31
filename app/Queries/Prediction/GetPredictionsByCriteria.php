<?php

namespace App\Queries\Prediction;

use App\Models\Prediction;
use App\Queries\Prediction\Filters\GameStatusFilter;
use App\Queries\Prediction\Filters\PoolFilter;
use App\Queries\Prediction\Filters\PoolRoundFilter;
use App\Queries\Prediction\Filters\PredictionStatusFilter;
use App\Queries\Prediction\Filters\UserFilter;
use App\Queries\Prediction\Filters\UserNotFilter;
use Illuminate\Pipeline\Pipeline;
use stdClass;

/**
 * Class GetPredictionsByCriteria
 */
class GetPredictionsByCriteria
{
    public function __invoke(
        GetPredictionsByCriteriaQuery $GetPredictionByCriteriaQuery
    ) {
        $QueryBuilder = Prediction::query();

        $DtoPipeline = new stdClass;
        $DtoPipeline->QueryBuilder = $QueryBuilder;
        $DtoPipeline->GetPredictionByCriteriaQuery = $GetPredictionByCriteriaQuery;

        return app(Pipeline::class)
            ->send($DtoPipeline)
            ->through([
                PoolFilter::class,
                UserFilter::class,
                PoolRoundFilter::class,
                GameStatusFilter::class,
                PredictionStatusFilter::class,
            ])
            ->then(fn($h)  => $h->QueryBuilder->select('predictions.*')->get());
    }
}
