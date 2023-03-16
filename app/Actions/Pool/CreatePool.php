<?php

namespace App\Actions\Pool;

use App\Exceptions\Pool\CompetitionMustBeUniqueInAPool;
use App\Models\Competition;
use App\Models\Pool;
use App\Models\User;
use Exception;
use Illuminate\Support\Collection;

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

        $competitionsCollect = collect($competitions);

        $haveCompetitionUnique = $competitionsCollect->count() > 1 && $competitionsCollect->filter(function (Competition $competition){
            return $competition->must_be_unique;
        })->count() > 0;

        if($haveCompetitionUnique){
            throw new CompetitionMustBeUniqueInAPool('Have competition unique');
        }

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
