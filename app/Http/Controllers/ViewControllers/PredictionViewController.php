<?php

namespace App\Http\Controllers\ViewControllers;

use App\Models\PoolRound;
use App\Queries\Games\GetGamesOwnerPoolRound;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class PredictionViewController extends Controller
{

    public function __construct(
        public GetGamesOwnerPoolRound $getGamesOwnerPoolRound
        ){

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
}