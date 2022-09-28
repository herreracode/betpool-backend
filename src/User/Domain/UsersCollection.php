<?php

namespace BetPoolCore\User\Domain;

use BetPoolCore\Shared\Domain\Utils\Collection as CollectionAbstract;
use BetPoolCore\User\Domain\Entities\User;

/**
 * Reports Class
 */
final class UsersCollection extends CollectionAbstract
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return User::class;
    }
}

