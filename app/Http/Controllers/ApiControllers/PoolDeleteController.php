<?php

namespace App\Http\Controllers\ApiControllers;

use App\Actions\Pool\DeletePool;
use App\Http\Controllers\Controller;
use App\Models\Pool;
use Illuminate\Http\Request;

class PoolDeleteController extends Controller
{
    public function __construct(public DeletePool $deletePool)
    {


    }

    public function __invoke($poolId)
    {
        $Pool = Pool::find($poolId);

        $this->deletePool->__invoke(
            auth()->user(),
            $Pool
        );

        return response()->json([
            'status' => 'true',
            'item' => []
        ], 204);

    }

}
