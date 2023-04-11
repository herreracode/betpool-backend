<?php

namespace App\Actions\Competition;

use App\Models\Competition;
use App\Models\CompetitionPhase;
use Exception;

/**
 * Class CreateCompetition
 */
class CreateCompetitionPhase
{
    public function __construct()
    {
    }


    /**
     * @param Competition $Competition
     * @param $name
     * @return CompetitionPhase
     * @throws Exception
     */
    public function __invoke(Competition $Competition, $name) : CompetitionPhase
    {
        return $Competition->addCompetitionPhase($name);
    }
}
