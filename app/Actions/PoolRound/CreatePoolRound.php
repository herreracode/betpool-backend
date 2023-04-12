<?php

namespace App\Actions\PoolRound;

use App\Models\Pool;
use App\Models\PoolRound;
use App\Models\User;

class CreatePoolRound
{

    public function __construct()
    {
    }

    public function __invoke(
        User $UserCreator,
        Pool $Pool,
        iterable $Games
    ): PoolRound {

        return $Pool->createRound($UserCreator, $Games);
    }
}
