<?php

namespace App\Queries\Prediction;

use App\Models\PoolRound;
use App\Models\Prediction;
use App\Models\User;
use App\Models\Enums\GameStatus;
use App\Models\Enums\PredictionStatus;

class GetOthersPredictionsByPoolRound
{

    public function __construct(public GetPredictionsByCriteria $getPredictionsByCriteria)
    {

    }

    public function __invoke(
        PoolRound $PoolRound,
        User $User
    ): array {

        $Users = $PoolRound->pool->users()->where('user_id', '!=', $User->id)->get();

        $payload = [];


        foreach ($Users as $User) {

            $predictionsFormat = $predictions = [];

            $query = new GetPredictionsByCriteriaQuery(
                user_id: $User->id,
                pool_round_id: $PoolRound->id,
                game_status: GameStatus::FINISH->value,
                prediction_status: PredictionStatus::CLOSE->value
            );

            $predictionsFormat = $this
                ->getPredictionsByCriteria
                ->__invoke($query)
                ->map(
                    $this->mapPredictionsWithData()
                )->toArray();

            $predictions = array_merge($predictions, $predictionsFormat);
            
            $payload[] = [
                'user' => $User->only([
                    'id', 'name'
                ]),
                'predictions' => $predictions
            ];
        }

        return $payload;
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