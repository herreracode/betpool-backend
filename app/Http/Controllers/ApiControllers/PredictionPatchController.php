<?php

namespace App\Http\Controllers\ApiControllers;

use App\Actions\PoolRound\CreatePoolRound;
use App\Actions\Prediction\CreatePrediction;
use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Game;
use App\Models\Pool;
use App\Models\PoolRound;
use Illuminate\Http\Request;

class PredictionPatchController extends Controller
{

    public function __construct(public CreatePrediction $createPrediction)
    {
    }


    public function __invoke($idPrediction, Request $request)
    {
        //$request->get('prediction');

        //todo: services to edit predictions
       
        return response()->json([
            'status' => 'true',
            'item' => "hola"
        ], 201);
    }

}