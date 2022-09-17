<?php

namespace BetPoolTest\Team\Domain;

use BetPoolCore\Team\Domain\Entities\Team;
use BetPoolCore\Team\Domain\VO\TeamName;
use BetPoolTest\TestCase as BetPoolTestTestCase;


class TeamTest extends BetPoolTestTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateTeamEntity()
    {
        $Name = new TeamName("LA VINOTINTO");

        $Team = Team::create(
            $Name,
        );

        $this->assertInstanceOf(Team::class, $Team);

        $this->assertInstanceOf(TeamName::class, $Team->getName());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateTeamEntityFromPrimitive()
    {
        $Name = "LA VINOTINTO";

        $Team = Team::createFromPrimitives($Name);

        $this->assertInstanceOf(Team::class, $Team);

        $this->assertInstanceOf(TeamName::class, $Team->getName());
    }
}
