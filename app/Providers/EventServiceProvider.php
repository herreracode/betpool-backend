<?php

namespace App\Providers;

use App\Events\AcceptInvitationPool;
use App\Events\GamePostponed;
use App\Events\UpdatedGameResult;
use App\Listeners\AddUserPoolWhenAcceptInvitation;
use App\Listeners\CancelPredictionsWhenPostponedGameListener;
use App\Listeners\ClosePredictionsWhenUpdatedGameResultListener;
use App\Listeners\SendEmailInvitationsUsersPool;
use Betpool\Pool\Domain\Events\CreatedPool;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CreatedPool::class => [
            SendEmailInvitationsUsersPool::class,
        ],
        UpdatedGameResult::class => [
            ClosePredictionsWhenUpdatedGameResultListener::class,
        ],
        AcceptInvitationPool::class => [
            AddUserPoolWhenAcceptInvitation::class,
        ],
        GamePostponed::class  => [
            CancelPredictionsWhenPostponedGameListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
