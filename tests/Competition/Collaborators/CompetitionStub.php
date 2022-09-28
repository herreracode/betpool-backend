<?php 

namespace BetPoolTest\Competition\Collaborators;

use BetPoolCore\Competition\Domain\Entities\Competition;
use BetPoolCore\Competition\Domain\VO\CompetitionName;
use BetPoolTest\Team\Collaborators\TeamStub;

class CompetitionStub
{
    public function __construct(
        private ?CompetitionName $name = null,
        private ?array $teams = null
    )
    {
    }

    public function create() : Competition
    {
        $competitionName =  $this->name ?? new CompetitionName("FIFA WORLD CUP QATAR 2022");

        $amountToCreateTEams = 12;

        $Teams = TeamStub::createMany($amountToCreateTEams);

        return new Competition(
            name : $competitionName,
            teams : $Teams
        );
    }
    
}
