<?php

namespace App\Queries\Prediction;

/**
 * Class GetGamesActionByCriteria
 */
class GetPredictionsByCriteriaQuery
{
    public function __construct(
        public ?int $pool_id
    ) {
    }
}