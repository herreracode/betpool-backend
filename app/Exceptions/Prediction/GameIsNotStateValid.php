<?php

namespace App\Exceptions\Prediction;

class GameIsNotStateValid extends \Exception
{
    public static function create($message) :static
    {
        return new static($message);
    }
}
