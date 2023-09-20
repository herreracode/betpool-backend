<?php

namespace App\Queries\Prediction;

use App\Models\PoolRound;
use App\Models\Prediction;

class GetPredictionsByPoolRound
{
    public function __invoke(
        PoolRound $PoolRound
    ) :array {
        
        $predictionsFormat = $predictions = [];

            $predictionsFormat = $PoolRound
            ->predictions
            ->map($this->mapPredictionsWithData()
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