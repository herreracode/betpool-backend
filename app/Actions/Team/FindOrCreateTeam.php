<?php

namespace App\Actions\Team;

use App\Models\Team;
use Exception;

/**
 * Class FindOrCreateTeam
 */
class FindOrCreateTeam
{
    public function __construct()
    {
    }

    public function __invoke($name, $abbreviation) : Team
    {
        $Team = Team::where([
            'abbreviation' => $abbreviation
        ])->first();

        return $Team ?? Team::create($name, $abbreviation);
    }
}
