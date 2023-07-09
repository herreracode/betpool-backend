<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Pool;
use Inertia\Inertia;

class TestController extends Controller
{
    public function hola()
    {
        return Inertia::render('Dashboard');
    }
}
