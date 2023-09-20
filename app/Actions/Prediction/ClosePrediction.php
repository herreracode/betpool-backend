<?php

namespace App\Actions\Prediction;

use App\DomainServices\Prediction\CalculateNumberOfPointsEarned;
use App\Models\Prediction;

/**
 * @property CalculateNumberOfPointsEarned $calculateNumberOfPointsEarned
 */
class ClosePrediction
{

    public function __construct(protected CalculateNumberOfPointsEarned $calculateNumberOfPointsEarned)
    {
    }

    public function __invoke(
        Prediction $Prediction
    ) : void
    {
        $Prediction->close($this->calculateNumberOfPointsEarned);
    }

}
