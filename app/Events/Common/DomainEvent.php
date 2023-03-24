<?php

namespace App\Events\Common;

use AllowDynamicProperties;
use App\Events\Common\Contracts\DomainEvent as DomainEventContract;
use App\Models\Pool;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * @property $Aggregate
 */
abstract class DomainEvent implements DomainEventContract
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public $Aggregate)
    {
    }

    public function getAggregate()
    {
        return $this->Aggregate;
    }

    public function dispatchDomainEvent()
    {
        $this::dispatch($this->getAggregate());
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
