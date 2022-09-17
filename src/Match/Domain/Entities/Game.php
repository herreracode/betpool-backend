<?php

namespace BetPoolCore\Match\Domain\Entities;

use BetPoolCore\Competition\Domain\Entities\CompetitionPhase;
use BetPoolCore\Team\Domain\Entities\Team;

/**
 * Class Match
 */
class Game
{
    
    public function __construct(
        public Team $LocalTeam,
        public Team $AwayTeam,
        public CompetitionPhase $CompetitionPhase,
    )
    {
    }

    public function getLocalTeam() : Team
    {
        return $this->LocalTeam;
    }
    
    public function getAwayTeam() : Team
    {
        return $this->AwayTeam;
    }
    
    public function getCompetitionPhase() : CompetitionPhase
    {
        return $this->CompetitionPhase;
    }

    public static function create(
        Team $LocalTeam,
        Team $AwayTeam,
        CompetitionPhase $CompetitionPhase,
    ): static
    {
        return new static(
            $LocalTeam,
            $AwayTeam,
            $CompetitionPhase,
        );
    }
}