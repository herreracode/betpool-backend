<?php

namespace Betpool\Pool\Features\Create;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use Illuminate\Http\Request;

class PoolCreateController extends Controller
{
    public function __construct(public CreatePool $createPool)
    {


    }

    public function __invoke(Request $request)
    {
        $idsCompetition = $request->get('competitions');

        $Competitions = Competition::whereIn('id', $idsCompetition)->get();

        $Pool = $this->createPool->__invoke(
            auth()->user(),
            $request->get('name'),
            $Competitions,
            $request->get('guests')
        );


        return response()->json([
            'status' => 'true',
            'item' => $Pool->only(['id', 'name'])
        ], 201);

    }

}
