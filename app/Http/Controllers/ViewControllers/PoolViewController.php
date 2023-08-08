<?php

namespace App\Http\Controllers\ViewControllers;

use Inertia\Inertia;
use App\Http\Controllers\Controller;

class PoolViewController extends Controller
{
    public function hola()
    {
        return Inertia::render('Dashboard');
    }
    
    public function getPoolIndividualView($idPool)
    {
        return Inertia::render('Pool/PoolIndividualView');
    }
    
    public function getPoolCreateView()
    {
        return Inertia::render('Pool/PoolCreate');
    }
}
