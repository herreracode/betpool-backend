<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Pool;
use Inertia\Inertia;

class TestController extends Controller
{
    public function hola()
    {
        $Pools = auth()->user()->pools;

        $formatPool = $Pools->map(fn($x) => $x->only([
            'name',
            'id',
            'is_closed',
        ]))->toArray();

        return Inertia::render('Dashboard', [
            'pools' => $formatPool
        ]);
    }
}