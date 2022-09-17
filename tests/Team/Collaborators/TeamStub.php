<?php

namespace BetPoolTest\Team\Collaborators;

use BetPoolCore\Team\Domain\Entities\Team;
use Exception;
use Faker\Factory;

class TeamStub
{
    private const AMOUNT_ALLOWED_TO_CREATE_TEAM = 100;

    public function __construct(
        protected ? string $name = null,
    )
    {
      
    }

    public function get() {

        $Faker = Factory::create();

        return Team::createFromPrimitives(
            $this->name ?? $Faker->countryISOAlpha3
        );
    }

    public static function createMany($numberTeamToFake = 32) : array
    {

        if($numberTeamToFake > static::AMOUNT_ALLOWED_TO_CREATE_TEAM)
            throw new Exception("much team to create");

        return array_map(function ($number) {
            
            return (new static())->get();

        }, range(1 , $numberTeamToFake));
        
    }
}