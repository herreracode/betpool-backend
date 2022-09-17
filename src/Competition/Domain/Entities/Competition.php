<?php

namespace BetPoolCore\Competition\Domain\Entities;

use BetPoolCore\Competition\Domain\VO\CompetitionName;

class Competition{
    

    public function __construct(
        public CompetitionName $name
    )
    {   
    }

    public function getName():CompetitionName
    {   
        return $this->name;
    }

    public static function create(
        CompetitionName $name
    ) :static
    {   
        return new static(
            $name
        );
    }

    public static function createFromPrimitives($name):static
    {   
        return static::create(
            new CompetitionName($name)
        );
    }

}