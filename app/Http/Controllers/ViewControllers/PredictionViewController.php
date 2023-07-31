<?php

namespace App\Http\Controllers\ViewControllers;

use Inertia\Inertia;
use App\Http\Controllers\Controller;

class PredictionViewController extends Controller
{

    public function createPredictionsView()
    {
        return Inertia::render('Prediction/PredictionCreate', [
        
        ]);
    }
}