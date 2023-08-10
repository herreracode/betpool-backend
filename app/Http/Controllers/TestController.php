<?php

namespace App\Http\Controllers;

use App\Queries\Pool\GetPoolsByUser;
use Inertia\Inertia;

class TestController extends Controller
{
    public function __construct(public GetPoolsByUser $getPoolsByUser){

    }

    public function hola()
    {
        $User = auth()->user();

        return Inertia::render('Dashboard', [
            'pools' => $this->getPoolsByUser->__invoke($User)
        ]);
    }
}