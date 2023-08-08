<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Pool;
use Inertia\Inertia;

class TestController extends Controller
{
    public function hola()
    {
        return Inertia::render('Dashboard', [
            'pools' => [
                [
                    'name' => "pool 2",
                    'uuid' => fake()->uuid(),
                    'is_closed' => false,
                ],
                [
                    'name' => "pool 3",
                    'uuid' => fake()->uuid(),
                    'is_closed' => false
                ],
                [
                    'name' => "pool 4",
                    'uuid' => fake()->uuid(),
                    'is_closed' => true
                ],
            ]
        ]);
    }
}
