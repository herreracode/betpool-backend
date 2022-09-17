<?php

namespace BetPoolTest\Match\Domain;

use BetPoolCore\Competition\Domain\Entities\CompetitionPhase;
use BetPoolCore\Match\Domain\Entities\Game;
use BetPoolCore\Team\Domain\Entities\Team;
use BetPoolTest\TestCase as BetPoolTestTestCase;


class GameTest extends BetPoolTestTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateGameEntity()
    {
        $AwayTeam = $this->getTeamStub();

        $LocalTeam = $this->getTeamStub("Netherlands");

        $CompetitionPhase = $this->getCompetitionPhaseStub();

        $Game = Game::create(
            $LocalTeam,
            $AwayTeam,
            $CompetitionPhase
        );

        $this->assertInstanceOf(Game::class, $Game);

        $this->assertInstanceOf(Team::class, $Game->getLocalTeam());
        
        $this->assertInstanceOf(Team::class, $Game->getAwayTeam());
        
        $this->assertInstanceOf(CompetitionPhase::class, $Game->getCompetitionPhase());
    }

    protected function getTeamStub($name = null) : Team
    {
        return Team::createFromPrimitives(
            $name ? :"Argentina"
        );
    }

    protected function getCompetitionPhaseStub($name = null) : CompetitionPhase
    {
        return CompetitionPhase::createFromPrimitives(
            $name ? :"_GROUP_"
        );
    }
}