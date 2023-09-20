<?php

namespace App\Exceptions\PoolRound;

use App\Exceptions\Prediction\Trait\IsException;

class GameIsNotPending extends \Exception
{
    use IsException;
}
