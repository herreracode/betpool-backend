<?php

namespace BetPoolCore\User\Domain\Entities;

use BetPoolCore\User\Domain\VO\UserActive;
use BetPoolCore\User\Domain\VO\UserEmail;
use BetPoolCore\User\Domain\VO\UserName;
use BetPoolCore\User\Domain\VO\UserRol;

/**
 * Class User
 */
class User
{

    /**
     * Undocumented function
     *
     * @param UserName $name
     * @param UserEmail $email
     * @param UserActive $active
     * @param UserRol $rol
     */
    public function __construct(
        public UserName $name,
        public UserEmail $email,
        public UserActive $active,
        public UserRol $rol,

    )
    {       
    }

    /**
     * Undocumented function
     *
     * @return UserEmail
     */
    public function getEmail() :UserEmail
    {
        return $this->email;
    }

    /**
     * Undocumented function
     *
     * @return UserName
     */
    public function getName() : UserName
    {
        return $this->name;
    }

    /**
     * Undocumented function
     *
     * @return UserActive
     */
    public function getActive() : UserActive
    {
        return $this->active;
    }

    /**
     * Undocumented function
     *
     * @return UserRol
     */
    public function getRol() : UserRol
    {
        return $this->rol;
    }


    /**
     * Undocumented function
     *
     * @return void
     */
    public static function create(
        UserName $name,
        UserEmail $email,
        UserActive $active,
        UserRol $rol
    )
    {
        return new static(
            $name,
            $email,
            $active,
            $rol,
        );
    }
    
    /**
     * Undocumented function
     *
     * @return void
     */
    public static function createFromPrimitives(
        string $name,
        string  $email,
        bool $active,
        string $rol
    )
    {
        return new static(
            new UserName($name),
            new UserEmail($email),
            new USerActive($active),
            new UserRol($rol),
        );
    }
    
}
