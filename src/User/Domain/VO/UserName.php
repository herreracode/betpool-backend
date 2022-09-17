<?php

namespace BetPoolCore\User\Domain\VO;

/**
 * Class UserName
 */
class UserName
{
    
    public function __construct(
        public string $name
    )
    {
    }

    public function get()
    {
        return $this->name;
    }

}
