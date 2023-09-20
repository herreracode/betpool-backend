<?php

namespace App\Http\Controllers\ViewControllers;

use App\Models\PoolRound;
use App\Models\Prediction;
use App\Queries\Games\GetGamesOwnerPoolRound;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class PredictionViewController extends Controller
{

    public function __construct(
        public GetGamesOwnerPoolRound $getGamesOwnerPoolRound
    ) {

    }

    public function createPredictionsView($idPoolRound)
    {
        $PoolRound = PoolRound::find($idPoolRound);

        return Inertia::render('Prediction/PredictionCreate', [
            "pool_round_id" => $idPoolRound,
            "games" => $this->getGamesOwnerPoolRound->__invoke(
                auth()->user(),
                $PoolRound
            )
        ]);
    }

    public function editPredictionsView($idPrediction)
    {
        $Prediction = Prediction::find($idPrediction);

        return Inertia::render('Prediction/PredictionEdit', [
            "pool_round_id" => $Prediction->PoolRound->id,
            "prediction" => $this->trasposePrediction($Prediction)
        ]);
    }

    /**
     * traspose prediction to format front-end
     *
     * @return void
     */
    protected function trasposePrediction(Prediction $prediction): array
    {
        return [
            "team_away" => $prediction->getAwayTeam()->name,
            "score_away" => $prediction->getAwayTeamScore(),
            "team_local" => $prediction->getLocalTeam()->name,
            "score_local" => $prediction->getLocalTeamScore(),
            "status" => $prediction->status,
            "id" => $prediction->id,
            "user_id" => $prediction->user_id,
            "pool_id" => $prediction->PoolRound->pool->id,
            "game_id" => $prediction->Game->id,
        ];
    }
}