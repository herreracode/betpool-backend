<?php

namespace App\Exceptions\Pool;

class UserDoesntBelongToThePool extends \Exception
{

    /**
     * @param $message
     * @return static
     */
    public static function create($message)
    {
        return new static($message);
    }

}
