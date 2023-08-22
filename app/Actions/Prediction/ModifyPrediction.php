<?php

namespace App\Actions\Prediction;

use App\Models\Prediction;

class ModifyPrediction
{

    public function __construct()
    {
    }

    public function __invoke(
        Prediction $Prediction,
        $scoreLocal,
        $scoreAway,
        $idUserModifier
    ): Prediction {
        return $Prediction->modify($scoreLocal, $scoreAway, $idUserModifier);
    }

}