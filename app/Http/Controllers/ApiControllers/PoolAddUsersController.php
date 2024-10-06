<?php

namespace App\Http\Controllers\ApiControllers;

use App\Actions\Pool\AddUserToPool;
use App\Models\Pool;
use App\Models\User;
use Illuminate\Http\Request;

class PoolAddUsersController
{
    public function __construct(public AddUserToPool $addUserToPool)
    {
    }

    public function __invoke($poolId, Request $request)
    {
        $guests = $request->get("guests");

        $Pool = Pool::find($poolId);

        foreach ($guests as $guest) {

            $User = User::where('email', $guest)->first();

            if ($User) {
                $this->addUserToPool->__invoke(
                    $User,
                    $Pool
                );
            }
        }

        return response()->json([
            'status' => 'true',
        ], 200);
    }

}
