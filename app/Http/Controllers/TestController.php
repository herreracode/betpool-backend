<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Pool;
use Inertia\Inertia;

class TestController extends Controller
{
    public function hola()
    {
        $Pool = Pool::all()->first();

        dd($Pool->competitions->first()->name);

        return Inertia::render('Dashboard');
    }
}
