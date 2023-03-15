<?php

namespace App\Actions\Pool;

use App\Models\Pool;
use App\Models\User;
use Exception;

/**
 * Class CreatePool
 */
class CreatePool
{
    
    public function __invoke(
        User $UserCreator,
        $namePool,
        iterable $competitions = null
    ): Pool {

        $Pool = new Pool();

        $Pool->name = $namePool;
        
        if (! $Pool->save()) {
            throw new Exception('dont save Pool');
        }

        //add users
        $Pool->users()->attach($UserCreator);
        
        //add competitions to pool
        $competitions && $Pool->competitions()->attach($competitions);
        
        return $Pool;
    }
}
