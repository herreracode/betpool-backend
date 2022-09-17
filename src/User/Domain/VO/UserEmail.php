<?php

namespace BetPoolCore\User\Domain\VO;

/**
 * Class UserEmail
 */
class UserEmail
{
    
    public function __construct(
        public string $email
    )
    {
    }

    public function get()
    {
        return $this->email;
    }

}
