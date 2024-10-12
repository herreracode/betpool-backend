<?php

namespace App\Http\Controllers\ApiControllers;

use App\Actions\PoolInvitationsEmails\DTO\RequestInviteGuest;
use App\Actions\PoolInvitationsEmails\InviteGuest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InviteGuestToPoolController extends Controller
{

    public function __construct(public InviteGuest $inviteGuest)
    {
    }

    public function __invoke($poolId, Request $request)
    {
        $request = new RequestInviteGuest(
            emails: request('guests'),
            poolId: $poolId
        );

        $response = $this->inviteGuest->__invoke($request);

        return response()->json([
            'status' => 'true',
            'summary' => $response->summary
        ], 200);
    }
}
