<?php

namespace App\Listeners;

use Betpool\Pool\Domain\Events\CreatedPool;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailInvitationsUsersPool implements ShouldQueue
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
     * @param  \Betpool\Pool\Domain\Events\CreatedPool  $event
     * @return void
     */
    public function handle(CreatedPool $event)
    {
        var_dump("hello");
    }
}
