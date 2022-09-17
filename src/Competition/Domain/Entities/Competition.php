<?php

namespace BetPoolCore\Competition\Domain\Entities;

use BetPoolCore\Competition\Domain\VO\CompetitionName;

class Competition{
    

    /**
     * constructor
     * 
     * TODO: array type pass to Colletion type for validate type object team
     *
     * @param CompetitionName $name
     * @param array $teams
     */
    public function __construct(
        public CompetitionName $name,
        public array $teams
    )
    {   
    }

    public function getName():CompetitionName
    {   
        return $this->name;
    }
    
    public function getTeams():array
    {   
        return $this->teams;
    }

    public static function create(
        CompetitionName $name,
        array $teams
    ) :static
    {   
        return new static(
            $name,
            $teams
        );
    }

    public static function createFromPrimitives(
        $name, 
        array $teams
        ):static
    {   
        return static::create(
            new CompetitionName($name),
            $teams
        );
    }

}