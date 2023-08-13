<?php

namespace App\Http\Controllers\ViewControllers;

use App\Models\Pool;
use App\Models\PoolRound;
use App\Queries\Games\GetGamesForPoolRound;
use App\Queries\Games\GetGamesOwnerPoolRound;
use App\Queries\Prediction\GetPredictionsByPoolRound;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class PoolRoundViewController extends Controller
{

    public function __construct(
        public GetGamesForPoolRound $GetGamesForPoolRound,
        public GetGamesOwnerPoolRound $getGamesOwnerPoolRound,
        public GetPredictionsByPoolRound $getPredictionsByPoolRound
        ){

    }

    public function getPoolRoundIndividualView($idPoolRound)
    {
        $PoolRound = PoolRound::find($idPoolRound);

        return Inertia::render(
            'PoolRound/PoolRoundIndividualView',
            [
                "number" => $idPoolRound,
                "games" => $this->getGamesOwnerPoolRound->__invoke(
                    auth()->user(),
                    $PoolRound
                ),
                'own_predictions' => $this->getPredictionsByPoolRound->__invoke(
                    $PoolRound
                ), 
            ]
        );
    }

    public function getPoolRoundCreateView($idPool)
    {
        $Pool = Pool::find($idPool);

        return Inertia::render('PoolRound/PoolRoundCreate', [
            'games' => $this->GetGamesForPoolRound->__invoke(
                auth()->user(),
                $Pool
            ),
            'id_pool' => $idPool
        ]);
    }
}