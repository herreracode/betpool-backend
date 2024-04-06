<?php

namespace App\Actions\Pool;

use App\Models\Pool;
use App\Models\User;

class DeletePool
{
    public function __invoke(
        User $DeleterUser,
        Pool $Pool,
    ): bool {

        return $Pool->delete();
    }
}
