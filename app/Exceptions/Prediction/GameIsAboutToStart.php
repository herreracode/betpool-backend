<?php

namespace App\Exceptions\Prediction;

class GameIsAboutToStart extends \Exception
{
    public static function create($message) :static
    {
        return throw new static($message);
    }

}
