<?php

namespace App\Http\Controllers\ApiControllers;

use App\Actions\PoolRound\CreatePoolRound;
use App\Actions\Prediction\CreatePrediction;
use App\Actions\Prediction\ModifyPrediction;
use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Game;
use App\Models\Pool;
use App\Models\PoolRound;
use App\Models\Prediction;
use Illuminate\Http\Request;

class PredictionPatchController extends Controller
{

    public function __construct(public ModifyPrediction $modifyPrediction)
    {
    }


    public function __invoke($idPrediction, Request $request)
    {
        $dataPrediction = $request->get('prediction');

        $Prediction = Prediction::find($idPrediction);

        //todo: services to edit predictions

        $this
            ->modifyPrediction
            ->__invoke(
                $Prediction,
                $dataPrediction['score_local'],
                $dataPrediction['score_away'],
                auth()->user()->id
            );

        return response()->json([
            'status' => 'true',
            'item' => "hola"
        ], 200);
    }

}