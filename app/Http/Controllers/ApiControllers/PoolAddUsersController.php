<?php

namespace App\Http\Controllers\ApiControllers;

use App\Actions\Pool\AddUserToPool;
use App\Actions\Pool\DTO\RequestAddUserPool;
use App\Exceptions\Pool\UserAlreadyAdded;
use App\Models\Pool;
use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class PoolAddUsersController
{
    public function __construct(public AddUserToPool $addUserToPool)
    {
    }

    /**
     * @throws UserAlreadyAdded
     */
    public function __invoke($poolId, Request $request)
    {
        $Request = new RequestAddUserPool(
            $poolId,
            $request->get("guests")
        );

        $this->addUserToPool->__invoke($Request);

        return response()->json([
            'status' => 'true',
        ], 200);
    }

}
