<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Inertia\Inertia;

class TestController extends Controller
{
    public function hola()
    {
        $Game = Game::all()->first();

        dd($Game->score->local_team_score);

        return Inertia::render('Dashboard');
    }
}
