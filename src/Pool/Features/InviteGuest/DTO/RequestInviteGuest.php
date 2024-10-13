<?php

namespace Betpool\Pool\Features\InviteGuest\DTO;

readonly class RequestInviteGuest
{

    public function __construct(public array $emails, public string $poolId)
    {
    }


}
