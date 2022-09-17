<?php

namespace BetPoolTest\Competition\Domain;

use BetPoolCore\Competition\Domain\Entities\CompetitionPhase;
use BetPoolCore\Competition\Domain\VO\CompetitionPhaseName;
use BetPoolTest\TestCase as BetPoolTestTestCase;


class CompetitionPhaseTest extends BetPoolTestTestCase
{
    public function testCreateCompetitionPhaseEntity()
    {
        $Name = new CompetitionPhaseName("_Group_");

        $CompetitionPhase = CompetitionPhase::create(
            $Name,
        );

        $this->assertInstanceOf(CompetitionPhase::class, $CompetitionPhase);

        $this->assertInstanceOf(CompetitionPhaseName::class, $CompetitionPhase->getName());
    }

    public function testCreateCompetitionPhaseEntityFromPrimitives()
    {
        $Name = "_Group_";

        $CompetitionPhase = CompetitionPhase::createFromPrimitives(
            $Name,
        );

        $this->assertInstanceOf(CompetitionPhase::class, $CompetitionPhase);

        $this->assertInstanceOf(CompetitionPhaseName::class, $CompetitionPhase->getName());
    }
}