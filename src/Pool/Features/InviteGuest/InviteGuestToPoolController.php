<?php

namespace Betpool\Pool\Features\InviteGuest;

use App\Http\Controllers\Controller;
use Betpool\Pool\Features\InviteGuest\DTO\RequestInviteGuest;
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
