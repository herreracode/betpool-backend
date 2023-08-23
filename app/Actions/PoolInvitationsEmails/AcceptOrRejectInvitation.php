<?php

namespace App\Actions\PoolInvitationsEmails;

use App\Events\Common\Contracts\EventBus;
use App\Models\PoolInvitationsEmails;

class AcceptOrRejectInvitation
{

    public function __construct(protected EventBus $eventBus)
    {
    }

    public function __invoke(
        PoolInvitationsEmails $poolInvitationsEmails,
        $acceptOrNot,
        $userId
    ): PoolInvitationsEmails {

        $acceptOrNot 
        ? $poolInvitationsEmails->accept($userId) 
        : $poolInvitationsEmails->reject($userId);

        $this->eventBus->dispatch($poolInvitationsEmails->pullDomainEvents());

        return $poolInvitationsEmails;
    }
}