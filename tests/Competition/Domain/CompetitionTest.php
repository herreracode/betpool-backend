<?php

namespace BetPoolTest\Competition\Domain;

use BetPoolCore\Competition\Domain\Entities\Competition;
use BetPoolCore\Competition\Domain\VO\CompetitionName;
use BetPoolTest\TestCase as BetPoolTestTestCase;

class CompetitionTest extends BetPoolTestTestCase
{
    public function testCreateCompetitionEntity()
    {
        $Name = new CompetitionName("FIFA WORLD CUP QATAR 2022");

        $Competition = Competition::create(
            $Name,
        );

        $this->assertInstanceOf(Competition::class, $Competition);

        $this->assertInstanceOf(CompetitionName::class, $Competition->getName());
    }

    public function testCreateCompetitionEntitFromPrimitives()
    {
        $Name = "FIFA WORLD CUP QATAR 2022";

        $Competition = Competition::createFromPrimitives(
            $Name,
        );

        $this->assertInstanceOf(Competition::class, $Competition);

        $this->assertInstanceOf(CompetitionName::class, $Competition->getName());
    }
}