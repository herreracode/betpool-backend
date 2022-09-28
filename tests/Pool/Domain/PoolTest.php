<?php

namespace BetPoolTest\Pool\Domain;

use BetPoolCore\Competition\Domain\Entities\Competition;
use BetPoolCore\Pool\Domain\Entities\Pool;
use BetPoolCore\Pool\Domain\VO\PoolName;
use BetPoolTest\Competition\Collaborators\CompetitionStub;
use BetPoolTest\TestCase as BetPoolTestTestCase;


class PoolTest extends BetPoolTestTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreatePoolEntity()
    {
        $Competition = (new CompetitionStub())->create();

        $Pool = Pool::create(
            new PoolName("Real Barcelona"),
            $Competition,
        );

        $this->assertInstanceOf(Pool::class, $Pool);

        $this->assertInstanceOf(PoolName::class, $Pool->getName());
        
        $this->assertInstanceOf(Competition::class, $Pool->getCompetition());
    }
}