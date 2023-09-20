<?php

namespace App\Exceptions\Prediction;
use App\Exceptions\Prediction\Trait\IsException;

class UserModifierNotOwner extends \Exception
{
    use IsException;
}
