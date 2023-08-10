<?php

namespace App\Http\Controllers\ViewControllers;

use Inertia\Inertia;
use App\Http\Controllers\Controller;

class PoolRoundViewController extends Controller
{

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

    public function getPoolRoundCreateView()
    {
        return Inertia::render('PoolRound/PoolRoundCreate', [
            
        ]);
    }
}