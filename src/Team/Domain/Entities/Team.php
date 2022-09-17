<?php

namespace BetPoolCore\Team\Domain\Entities;

use BetPoolCore\Team\Domain\VO\TeamName;

/**
 * Class UserName
 */
class Team
{
    
    public function __construct(
        public TeamName $name
    )
    {
    }

    public function getName() : TeamName
    {
        return $this->name;
    }

    public static function create(
            TeamName $teamName
    ): static
    {
        return new static(
            $teamName
        );
    }

    public static function createFromPrimitives(
            string $name
    ): static
    {
       return static::create(
            new TeamName($name)
       );
    }
}