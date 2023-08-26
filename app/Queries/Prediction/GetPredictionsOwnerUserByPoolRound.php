<?php

namespace App\Queries\Prediction;

use App\Models\PoolRound;
use App\Models\Prediction;
use App\Models\User;
use App\Queries\Prediction\Filters\PoolRoundFilter;
use App\Queries\Prediction\Filters\UserFilter;

class GetPredictionsOwnerUserByPoolRound
{

    public function __construct(public GetPredictionsByCriteria $getPredictionsByCriteria)
    {

    }

    public function __invoke(
        PoolRound $PoolRound,
        User $user
    ): array {

        $predictionsFormat = $predictions = [];

        $PredicitonsObjects = $this->getPredictionsByCriteria->__invoke(
            new GetPredictionsByCriteriaQuery(
                pool_round_id: $PoolRound->id,
                user_id: $user->id)
        );

        $predictionsFormat = $PredicitonsObjects
            ->map(
                $this->mapPredictionsWithData()
            )->toArray();

        $predictions = array_merge($predictions, $predictionsFormat);

        return $predictions;


    }

    protected function mapPredictionsWithData()
    {

        return function (Prediction $prediction) {

            $array = [
                'team_away' => $prediction->getAwayTeam()->name,
                'score_away' => $prediction->getAwayTeamScore(),
                'team_local' => $prediction->getLocalTeam()->name,
                'score_local' => $prediction->getLocalTeamScore(),
                'points_earned' => $prediction->points_earned,
                'description' => $prediction->getLocalTeam()->name . ' vs ' . $prediction->getAwayTeam()->name,
            ];


            $keysOnly = $prediction->only([
                'status',
                'id',
            ]);

            return array_merge($array, $keysOnly);
        };
    }
}