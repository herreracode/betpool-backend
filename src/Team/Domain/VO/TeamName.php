<?php

namespace BetPoolCore\Team\Domain\VO;

/**
 * Class UserName
 */
class TeamName
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