<?php

namespace BetPoolCore\User\Domain\VO;

/**
 * Class UserName
 */
class UserActive
{
    
    public function __construct(
        public bool $active
    )
    {
    }

    public function get()
    {
        return $this->active;
    }

}
