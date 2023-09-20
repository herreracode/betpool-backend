<?php

namespace App\Exceptions\PoolRound;

use App\Exceptions\Prediction\Trait\IsException;

class AlreadyHavePoolRoundPending extends \Exception
{
    use IsException;
}
