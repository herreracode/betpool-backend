<?php

namespace App\Exceptions\PoolRound;

use App\Exceptions\Prediction\Trait\IsException;

class UserDoesNotHaveTheRequiredRole extends \Exception
{
    use IsException;
}
