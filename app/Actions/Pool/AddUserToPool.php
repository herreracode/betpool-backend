<?php

namespace App\Actions\Pool;

use App\Models\Pool;
use App\Models\User;

class AddUserToPool
{
    public function __invoke(User $User, Pool $Pool) :bool
    {
        $Pool->addUser($User);

        return true;
    }


}
