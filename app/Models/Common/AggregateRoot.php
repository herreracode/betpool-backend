<?php

namespace App\Models\Common;

use App\Events\Common\Contracts\DomainEvent;
use Illuminate\Database\Eloquent\Model;

abstract class AggregateRoot extends Model
{
    private array $domainEvents = [];

    final public function pullDomainEvents(): array
    {
        $domainEvents       = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    final protected function record(DomainEvent $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }

}
