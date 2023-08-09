<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PoolPostController extends Controller
{
    public function __invoke(Request $request){

       return response()->json([
            'name' => 'Abigail',
            'state' => 'CA',
        ]);

    }
    
}
