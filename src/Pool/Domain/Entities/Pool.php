<?php

declare(strict_types=1);

namespace BetPoolCore\Pool\Domain\Entities;

use BetPoolCore\Competition\Domain\Entities\Competition;
use BetPoolCore\Pool\Domain\VO\PoolName;
use BetPoolCore\Pool\Domain\VO\PoolNname;
use BetPoolCore\User\Domain\UsersCollection;

/**
 * Undocumented class
 */
class Pool
{

    public function __construct(
        private PoolName $poolName,
        private Competition $Competition,
    )
    {
    }

    /**
     * Undocumented function
     * 
     * TODO: USERS COLLECTION
     * TODO: PREDICTION COLLECTION
     *
     * @return static
     */
    public static function create(
        PoolName $poolName,
        Competition $Competition,
    ) : static
    {
        return new static(
            $poolName,
            $Competition
        );
    }
    
    /**
     * get name
     *
     * @return PoolName
     */
    public function getName() : PoolName
    {
        return $this->poolName;
    }

    public function getCompetition() :Competition
    {
        return $this->Competition;
    }
}
