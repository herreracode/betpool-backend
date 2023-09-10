<?php

namespace App\Exceptions\Prediction;

use App\Exceptions\Prediction\Trait\IsException;

class ExistsPrediction extends \Exception
{
    use IsException;
}
