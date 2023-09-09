<?php

namespace App\Actions\Game;

use App\Events\Common\Contracts\EventBus;
use App\Models\Game;

class PostponeGame
{
    public function __construct(protected EventBus $eventBus)
    {
    }

    /**
     * @param Game $Game
     *
     * @return void
     */
    public function __invoke(Game $Game) : Game
    {
        $Game->postpone();

        $this->eventBus->dispatch($Game->pullDomainEvents());

        return $Game;
    }
}
