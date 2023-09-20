<?php

namespace App\Queries\Pool;

use App\Models\User;

class GetPoolsByUser
{
    public function __invoke(
        User $User
    ) :array {
        
        $Pools = $User->pools;

        return $Pools->map(fn($x) => $x->only([
            'name',
            'id',
            'is_closed',
        ]))->toArray();
    }
}