<?php

namespace App\Providers;

use App\Events\Common\Contracts\EventBus as EventBusContract;
use App\Events\Common\EventBusLaravel;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EventBusContract::class, EventBusLaravel::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
