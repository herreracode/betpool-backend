<?php

namespace App\Actions\Pool;

use App\Models\User;
use Betpool\Pool\Domain\Pool;

class DeletePool
{
    public function __invoke(
        User $DeleterUser,
        Pool $Pool,
    ): bool {

        return $Pool->delete();
    }
}
