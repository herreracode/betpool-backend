<?php

namespace App\Actions\PoolInvitationsEmails;

use App\Actions\PoolInvitationsEmails\DTO\RequestInviteGuest;
use App\Actions\PoolInvitationsEmails\DTO\ResponseInviteGuest;
use App\Exceptions\Pool\UserAlreadyAdded;
use App\Models\Pool;

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
