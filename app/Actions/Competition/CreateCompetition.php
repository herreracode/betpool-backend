<?php

namespace App\Actions\Competition;

use App\Models\Competition;
use Exception;

/**
 * Class CreateCompetition
 */
class CreateCompetition
{
    public function __construct()
    {
    }

    /**
     * @param $name
     * @return Competition
     * @throws Exception
     */
    public function __invoke($name, $externalApiKey) : Competition
    {
        return Competition::create($name, $externalApiKey);
    }
}
