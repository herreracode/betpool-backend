<?php

namespace App\Http\Controllers\ApiControllers;

use App\Actions\PoolRound\CreatePoolRound;
use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Game;
use App\Models\Pool;
use Illuminate\Http\Request;

class PoolRoundPostController extends Controller
{
    public function __construct(public CreatePoolRound $createPoolRound)
    {


    }

    public function __invoke(Request $request)
    {
        $idsGames = $request->get('games');

        $Games = Game::whereIn('id', $idsGames)->get();

        $Pool = Pool::find($request->get('id_pool'));

        $PoolRound = $this->createPoolRound->__invoke(
            auth()->user(),
            $Pool,
            $Games
        );

        return response()->json([
            'status' => 'true',
            'item' => "hola"
        ], 201);

    }

}