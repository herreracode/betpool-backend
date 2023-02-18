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

    public function __invoke($name)
    {
        $Team = new Team();

        $Team->name = $name;

        if (!$Team->save()) {
            throw new Exception('dont save team');
        }

        return $Team;
    }
}
