<?php

namespace Betpool\Pool\Features\InviteGuest;

use Betpool\Pool\Features\InviteGuest\DTO\RequestInviteGuest;
use Betpool\Pool\Features\InviteGuest\DTO\ResponseInviteGuest;
use Betpool\Pool\Domain\Pool;

class InviteGuest
{

    public function __invoke(RequestInviteGuest $request): ResponseInviteGuest
    {

        /**
         * @var Pool $Pool
         */
        $Pool = Pool::find($request->poolId);

        $response = new ResponseInviteGuest();

        foreach ($request->emails as $emailGuest) {
            try {
                $Pool->inviteGuestByEmailsOrFail($emailGuest);

                $response->summary[] = [
                    'email' => $emailGuest,
                    'message' => 'USER_INVITED',
                    'status' => true
                ];

            } catch (\Exception $e) {

                $response->summary[] = [
                    'email' => $emailGuest,
                    'message' => $e->getMessage(),
                    'status' => false
                ];
            }
        }

        return $response;
    }

}
