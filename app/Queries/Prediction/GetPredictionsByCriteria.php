<?php

namespace App\Queries\Prediction;

use App\Models\Prediction;
use Illuminate\Pipeline\Pipeline;
use stdClass;
use Illuminate\Support\Facades\DB;

/**
 * Class GetPredictionsByCriteria
 */
class GetPredictionsByCriteria
{
    public function __invoke(
        GetPredictionsByCriteriaQuery $GetPredictionByCriteriaQuery,
        ...$filters
    ) {
        $QueryBuilder = Prediction::query();

        $DtoPipeline = new stdClass;
        $DtoPipeline->QueryBuilder = $QueryBuilder;
        $DtoPipeline->GetPredictionByCriteriaQuery = $GetPredictionByCriteriaQuery;

        return app(Pipeline::class)
            ->send($DtoPipeline)
            ->through($filters)
            ->thenReturn()
            ->get();
    }
}
