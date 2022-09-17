<?php

namespace BetPoolCore\User\Domain;

use BetPoolCore\User\Domain\Entities\User;
use BetPoolCore\User\Domain\VO\UserActive;
use BetPoolCore\User\Domain\VO\UserEmail;
use BetPoolCore\User\Domain\VO\UserName;
use BetPoolCore\User\Domain\VO\UserRol;
use BetPoolTest\TestCase as BetPoolTestTestCase;

class UserTest extends BetPoolTestTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateUserEntity()
    {
        $Name = new UserName("test name user");
        $Email = new UserEmail("email@example.com");
        $Active = new UserActive((bool) true);
        $Rol = new UserRol("_ADMIN_");

        $User = User::create(
            $Name,
            $Email,
            $Active,
            $Rol,
        );

        $this->assertInstanceOf(User::class, $User);

        $this->assertInstanceOf(UserName::class, $User->getName());

        $this->assertInstanceOf(UserEmail::class, $User->getEmail());

        $this->assertInstanceOf(UserActive::class, $User->getActive());

        $this->assertInstanceOf(UserRol::class, $User->getRol());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateUserEntityFromPrimitive()
    {
        $Name = "test name user";
        $Email = "email@example.com";
        $Active = (bool) true;
        $Rol = "_ADMIN_";

        $User = User::createFromPrimitives(
            $Name,
            $Email,
            $Active,
            $Rol,
        );

        $this->assertInstanceOf(User::class, $User);

        $this->assertInstanceOf(UserName::class, $User->getName());

        $this->assertInstanceOf(UserEmail::class, $User->getEmail());

        $this->assertInstanceOf(UserActive::class, $User->getActive());

        $this->assertInstanceOf(UserRol::class, $User->getRol());
    }
}
