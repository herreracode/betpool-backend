<?php

namespace App\Exceptions\Prediction\Trait;

trait IsException
{
    public static function create($message) :static
    {
        return new static($message);
    }
}
