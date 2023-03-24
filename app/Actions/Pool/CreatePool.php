<?php

namespace App\Actions\Pool;

use App\Events\Common\Contracts\EventBus;
use App\Models\Pool;
use App\Models\User;

/**
 * Class CreatePool
 *
 * @package App\Actions\Pool
 */
class CreatePool
{

    public function __construct(protected EventBus $eventBus)
    {
    }

    public function __invoke(
        User $UserCreator,
        string $namePool,
        iterable $competitions = null,
        iterable $emailsPossiblesUsersPools = null
    ): Pool {

        $Pool = Pool::create($namePool);

        $UserCreator->addRoleUserCreatorByPool($Pool);

        //add user creator
        $Pool->addUser($UserCreator);

        //add competitions to pool
        $competitions && $Pool->addCompetitions($competitions);

        //add invitations pool users
        $emailsPossiblesUsersPools && $Pool->createInvitationsPoolEmails($emailsPossiblesUsersPools);

        $this->eventBus->dispatch($Pool->pullDomainEvents());

        return $Pool;
    }

}
