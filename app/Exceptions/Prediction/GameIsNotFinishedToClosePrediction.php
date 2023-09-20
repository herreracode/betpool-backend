<?php

namespace App\Exceptions\Prediction;

use App\Exceptions\Prediction\Trait\IsException;

class GameIsNotFinishedToClosePrediction extends \Exception
{
    use IsException;

}
