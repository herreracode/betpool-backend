<?php

namespace Betpool\Pool\Domain\Exceptions;

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
