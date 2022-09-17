<?php

namespace BetPoolCore\Competition\Domain\Entities;

use BetPoolCore\Competition\Domain\VO\CompetitionPhaseName;

class CompetitionPhase{
    

    public function __construct(
        public CompetitionPhaseName $name
    )
    {   
    }

    public function getName():CompetitionPhaseName
    {   
        return $this->name;
    }

    public static function create(
        CompetitionPhaseName $name
    ) :static
    {   
        return new static(
            $name
        );
    }

    public static function createFromPrimitives($name):static
    {   
        return static::create(
            new CompetitionPhaseName($name)
        );
    }

}