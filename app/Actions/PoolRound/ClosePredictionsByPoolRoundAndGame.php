<?php

namespace App\Actions\PoolRound;

use App\DomainServices\Prediction\CalculateNumberOfPointsEarned;
use App\Models\Game;
use App\Models\PoolRound;

class ClosePredictionsByPoolRoundAndGame
{

    public function __construct(protected CalculateNumberOfPointsEarned $calculateNumberOfPointsEarned)
    {
    }

    public function __invoke(
       PoolRound $poolRound,
       Game $game
    ): PoolRound {

        return $poolRound->closePredictions($game, $this->calculateNumberOfPointsEarned);
    }
}
