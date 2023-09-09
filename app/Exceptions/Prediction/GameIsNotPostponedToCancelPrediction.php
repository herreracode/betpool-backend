<?php

namespace App\Exceptions\Prediction;

use App\Exceptions\Prediction\Trait\IsException;

class GameIsNotPostponedToCancelPrediction extends \Exception
{
    use IsException;

}
