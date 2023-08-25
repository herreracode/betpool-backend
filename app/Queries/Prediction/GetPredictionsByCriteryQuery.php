<?php

namespace App\Queries\Prediction;

/**
 * Class GetGamesActionByCriteria
 */
class GetPredictionsByCriteryQuery
{
    public function __construct(
        public ?int $pool_id
    ) {
    }
}