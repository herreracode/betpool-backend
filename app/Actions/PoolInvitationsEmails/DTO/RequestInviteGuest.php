<?php

namespace App\Actions\PoolInvitationsEmails\DTO;

readonly class RequestInviteGuest
{

    public function __construct(public array $emails, public string $poolId)
    {
    }


}
