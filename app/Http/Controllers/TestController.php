<?php

namespace App\Http\Controllers;

use App\Models\PoolInvitationsEmails;
use App\Queries\Pool\GetPoolsByUser;
use Inertia\Inertia;

class TestController extends Controller
{
    public function __construct(public GetPoolsByUser $getPoolsByUser){

    }

    public function hola()
    {
        $User = auth()->user();
        $email = $User->email;

        return Inertia::render('Dashboard', [
            'pools' => $this->getPoolsByUser->__invoke($User),
            'invitations_pools' => PoolInvitationsEmails::where('email', '=', $email)
                ->where('effective', '=', 1)
                ->whereNull('accepted')
                ->get()
        ]);
    }
}