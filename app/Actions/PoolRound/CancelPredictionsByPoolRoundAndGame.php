<?php

namespace App\Actions\PoolRound;

use App\DomainServices\Prediction\CalculateNumberOfPointsEarned;
use App\Models\Game;
use App\Models\PoolRound;

class CancelPredictionsByPoolRoundAndGame
{


    public function __invoke(
       PoolRound $poolRound,
       Game $game
    ): PoolRound {

        return $poolRound->cancelPredictions($game);
    }
}
