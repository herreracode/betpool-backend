<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Prediction;
use App\Models\Score;
use App\Models\User;
use Inertia\Inertia;

class TestController extends Controller
{
    public function hola()
    {
        $Score = User::all()->first();

        dd($Score->pools);

        return Inertia::render('Dashboard');
    }
}
