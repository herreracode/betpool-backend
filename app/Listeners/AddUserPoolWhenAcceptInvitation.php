<?php

namespace App\Listeners;

use App\Events\AcceptInvitationPool;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddUserPoolWhenAcceptInvitation implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * The name of the connection the job should be sent to.
     *
     * @var string|null
     */
    public $connection = 'database';

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\CreatedPool  $event
     * @return void
     */
    public function handle(AcceptInvitationPool $event)
    {
        $PoolInvitation = $event->getAggregate();

        $User = User::find($PoolInvitation->user_id);

        $PoolInvitation->pool->addUser($User);
    }
}
