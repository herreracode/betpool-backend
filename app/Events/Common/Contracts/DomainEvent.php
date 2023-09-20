<?php

namespace App\Events\Common\Contracts;

interface DomainEvent
{
    public function dispatchDomainEvent();
}
