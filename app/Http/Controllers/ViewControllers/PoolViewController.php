<?php

namespace App\Http\Controllers\ViewControllers;

use App\Models\Pool;
use App\Queries\Pool\GetPositionTableByPool;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\Competition;

class PoolViewController extends Controller
{
    public function __construct(public GetPositionTableByPool $getPositionTableByPool){

    }

    public function hola()
    {
        return Inertia::render('Dashboard');
    }
    
    public function getPoolIndividualView($idPool)
    {
        $Pool = Pool::find($idPool);

        return Inertia::render('Pool/PoolIndividualView',[
            "pool" => $Pool->only(['id', 'name', 'is_closed']),
            "pool_rounds" => $Pool->poolRound,
            "positions_table" => $this->getPositionTableByPool->__invoke($Pool)
        ]);
    }
    
    public function getPoolCreateView()
    {
        return Inertia::render('Pool/PoolCreate',[
            'competitions' => Competition::all()
        ]);
    }
}
