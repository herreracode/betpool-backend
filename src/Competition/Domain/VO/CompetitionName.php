<?php

namespace BetPoolCore\Competition\Domain\VO;

class CompetitionName {
    

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