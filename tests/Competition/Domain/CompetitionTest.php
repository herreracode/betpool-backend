<?php

namespace BetPoolTest\Competition\Domain;

use BetPoolCore\Competition\Domain\Entities\Competition;
use BetPoolCore\Competition\Domain\VO\CompetitionName;
use BetPoolTest\Team\Collaborators\TeamStub;
use BetPoolTest\TestCase as BetPoolTestTestCase;

class CompetitionTest extends BetPoolTestTestCase
{
    public function testCreateCompetitionEntity()
    {
        $Name = new CompetitionName("FIFA WORLD CUP QATAR 2022");

        $amountToCreateTEams = 12;

        $Teams = TeamStub::createMany($amountToCreateTEams);

        $Competition = Competition::create(
            $Name,
            $Teams
        );

        $this->assertInstanceOf(Competition::class, $Competition);

        $this->assertInstanceOf(CompetitionName::class, $Competition->getName());
        
        $this->assertTrue($amountToCreateTEams == count($Competition->getTeams()));
    }

    public function testCreateCompetitionEntitFromPrimitives()
    {
        $Name = "FIFA WORLD CUP QATAR 2022";

        $amountToCreateTEams = 24;

        $Teams = TeamStub::createMany($amountToCreateTEams);

        $Competition = Competition::createFromPrimitives(
            $Name,
            $Teams,
        );

        $this->assertInstanceOf(Competition::class, $Competition);

        $this->assertInstanceOf(CompetitionName::class, $Competition->getName());
    }
}