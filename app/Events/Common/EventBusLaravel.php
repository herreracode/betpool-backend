<?php

namespace App\Events\Common;

use App\Events\Common\Contracts\EventBus as EventBusContract;

class EventBusLaravel implements EventBusContract
{
    /**
     * @param array $events
     * @return void
     */
    public function dispatch(array $events) : void
    {
        collect($events)->each(fn($event) => $event->dispatchDomainEvent());
    }

}
