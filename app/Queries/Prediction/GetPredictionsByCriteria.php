<?php

namespace App\Queries\Prediction;

use App\Models\Prediction;
use Illuminate\Pipeline\Pipeline;
use stdClass;

/**
 * Class GetPredictionsByCriteria
 */
class GetPredictionsByCriteria
{
    public function __invoke(
        GetPredictionsByCriteryQuery $GetPredictionByCriteriaQuery,
        ...$filters
    ) {
        $QueryBuilder = Prediction::query();

        $DtoPipeline = new stdClass;
        $DtoPipeline->QueryBuilder = $QueryBuilder;
        $DtoPipeline->GetGameByCriteriaQuery = $GetPredictionByCriteriaQuery;

        return app(Pipeline::class)
            ->send($DtoPipeline)
            ->through($filters)
            ->thenReturn()
            ->get();
    }
}
