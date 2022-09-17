<?php

namespace BetPoolCore\User\Domain\VO;

/**
 * Class UserName
 */
class UserRol
{
    
    public function __construct(
        public string $rol
    )
    {
    }

    public function get()
    {
        return $this->rol;
    }

}
