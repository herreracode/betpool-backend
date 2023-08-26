<?php

namespace App\Queries\Prediction;

/**
 * Class GetGamesActionByCriteria
 */
class GetPredictionsByCriteriaQuery
{
    public function __construct(
        public ?int $pool_id = null,
        public ?int $user_id = null,
        public ?int $pool_round_id = null,
    ) {
    }
}