<?php

namespace App\Http\Controllers\ViewControllers;

use Inertia\Inertia;
use App\Http\Controllers\Controller;

class PredictionViewController extends Controller
{

    public function createPredictionsView()
    {
        return Inertia::render('Prediction/PredictionCreate', [
            "games" => [
                [
                    'id' => '23',
                    'team_local' => 'Barcelona',
                    'team_away' => 'Real Madrid',
                    'date_start' => '30/07/2023'
                ],
                [
                    'id' => '67',
                    'team_local' => 'Milan',
                    'team_away' => 'inter',
                    'date_start' => '27/07/2023'
                ],
                [
                    'id' => '56',
                    'team_local' => 'Juventus',
                    'team_away' => 'Atletico madrid',
                    'date_start' => '24/07/2025'
                ],
            ]
        ]);
    }
}