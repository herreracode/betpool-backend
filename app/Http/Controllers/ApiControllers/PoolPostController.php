<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;

class PoolPostController extends Controller
{
    public function __invoke(){

       return response()->json([
            'name' => 'Abigail',
            'state' => 'CA',
        ]);

    }
    
}
