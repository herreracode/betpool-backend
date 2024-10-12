<?php

namespace App\Actions\Pool;

use App\Actions\Pool\DTO\RequestAddUserPool;
use App\Exceptions\Pool\UserAlreadyAdded;
use App\Models\Pool;
use App\Models\User;

class AddUserToPool
{
    /**
     * @throws UserAlreadyAdded
     */
    public function __invoke(RequestAddUserPool $requestAddUserPool) :bool
    {
        /**
         * @var Pool $Pool
         */
        $Pool = Pool::find($requestAddUserPool->poolId);


        foreach ($requestAddUserPool->guestsEmails as $guest) {
            $User = User::where('email', $guest)->first();

            if ($User) {
                $Pool->addUser($User);
            }
        }

        return true;
    }


}
