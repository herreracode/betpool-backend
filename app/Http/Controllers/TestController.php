<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class TestController extends Controller
{
    

    public function hola(){

        return Inertia::render('Dashboard');

    }
}
