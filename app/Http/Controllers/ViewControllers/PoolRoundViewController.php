<?php

namespace App\Http\Controllers\ViewControllers;

use App\Models\Pool;
use App\Queries\Games\GetGamesForPoolRound;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class PoolRoundViewController extends Controller
{

    public function __construct(public GetGamesForPoolRound $GetGamesForPoolRound){

    }

    public function getPoolRoundIndividualView($idPoolRound)
    {
        return Inertia::render('PoolRound/PoolRoundIndividualView', [
            "number" => $idPoolRound,
            "games" => [
                [
                    'name' => 'Barcelona vs Real Madrid',
                    'calories' => '30/07/2023'
                ],[
                    'name' => 'Milan vs inter',
                    'calories' => '27/07/2023'
                ],[
                    'name' => 'Juventus vs Atletico madrid',
                    'calories' => '24/07/2025'
                ],
            ]
        ]);
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