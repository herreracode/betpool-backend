<?php

namespace App\Queries\Pool;

use App\Models\Pool;
use App\Models\Prediction;
use App\Models\User;
use App\Queries\Prediction\Filters\PoolFilter;
use App\Queries\Prediction\Filters\UserFilter;
use App\Queries\Prediction\GetPredictionsByCriteria;
use App\Queries\Prediction\GetPredictionsByCriteriaQuery;

class GetPositionTableByPool
{
    public function __construct(public GetPredictionsByCriteria $getPredictionsByCriteria)
    {

    }

    public function __invoke(
        Pool $pool
    ) :iterable {
        
        $Users = $pool->users;

        return $Users->map(function (User $User) use($pool){
                return [
                    'user_name' => $User->name,
                    'user_id' => $User->id,
                    'total_points_earned' => $this->getTotalPointsEarned($User, $pool)
                ];
        });
    }

    private function getTotalPointsEarned(User $User, Pool $Pool)
    {
        $query = new GetPredictionsByCriteriaQuery(user_id: $User->id, pool_id: $Pool->id);

        $Predictions = $this->getPredictionsByCriteria->__invoke(
            $query,
            PoolFilter::class,
            UserFilter::class
        );

        $sum = 0;

        $Predictions->each(function (Prediction $prediction) use (&$sum){
            $sum+= $prediction->points_earned;
        });

        return $sum;
    }
}