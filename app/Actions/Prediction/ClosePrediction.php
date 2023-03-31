<?php

namespace App\Actions\Prediction;

use App\Models\Prediction;

class ClosePrediction
{

    public function __invoke(
        Prediction $Prediction
    ) : void
    {
        $Prediction->close();
    }

}
