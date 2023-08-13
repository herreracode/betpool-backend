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

class PredictionPostController extends Controller
{

    public function __construct(public CreatePrediction $createPrediction)
    {
    }


    public function __invoke(Request $request)
    {
        $predictions = $request->get('predictions');

        $PoolRound = PoolRound::find($request->get('pool_round_id'));

        $Pool = $PoolRound->pool;
        
        $User = auth()->user();

        foreach($predictions as $prediction){

            $Game = Game::find($prediction['id']);

            $this->createPrediction->__invoke(
                User: $User,
                Pool: $Pool,
                Game: $Game,
                PoolRound : $PoolRound,
                localTeamScore: $prediction['score_local'],
                awayTeamScore: $prediction['score_away']
            );

        }


        return response()->json([
            'status' => 'true',
            'item' => "hola"
        ], 201);

    }

}