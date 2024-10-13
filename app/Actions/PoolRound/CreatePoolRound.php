<?php

namespace App\Actions\PoolRound;

use App\Models\PoolRound;
use App\Models\User;
use Betpool\Pool\Domain\Pool;

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
