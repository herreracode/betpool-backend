<?php

namespace App\Actions\Team;

use App\Models\Team;
use Exception;

/**
 * Class CreateTeam
 */
class CreateTeam
{
    public function __construct()
    {
    }

    public function __invoke($name) : Team
    {
        return Team::create($name);
    }
}
