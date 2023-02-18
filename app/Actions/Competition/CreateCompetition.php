<?php

namespace App\Actions\Competition;

use App\Models\Competition;
use Exception;

/**
 * Class CreateCompetition
 * 
 * @package App\Http\Actions\Competition
 */
class CreateCompetition
{

    public function __construct()
    {
        
    }

    public function __invoke($name)
    {
        $Competition = new Competition();

        $Competition->name = $name;

        if(!$Competition->save())
            throw new Exception("dont save competition");

        return $Competition;
    }
    
}
