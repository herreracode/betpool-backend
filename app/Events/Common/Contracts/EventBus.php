<?php

namespace App\Events\Common\Contracts;

interface EventBus
{
    public function dispatch(array $events) : void;

}
