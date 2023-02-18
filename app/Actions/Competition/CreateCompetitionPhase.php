<?php

namespace App\Actions\Competition;

use App\Models\Competition;
use App\Models\CompetitionPhase;
use Exception;

/**
 * Class CreateCompetition
 * 
 * @package App\Http\Actions\Competition
 */
class CreateCompetitionPhase
{

    public function __construct()
    {
        
    }

    public function __invoke(Competition $Competition, $name)
    {
        $CompetitionPhase = new CompetitionPhase();

        $CompetitionPhase->name = $name;

        $CompetitionPhase = $Competition->competitionPhases()->create([
            'name' => $name
        ]);

        if(!$CompetitionPhase)
            throw new Exception("dont save competition phase");

        return $CompetitionPhase;
    }
    
}
