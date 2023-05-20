<?php

namespace App\Providers;

use App\Actions\Game\Contract\GetterGamesExternalApi;
use App\Events\Common\Contracts\EventBus as EventBusContract;
use App\Events\Common\EventBusLaravel;
use App\Http\Clients\EspnApiClient;
use App\InfrastructureServices\GetterGamesExternalEspn;
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

        $this->app->bind(GetterGamesExternalApi::class, function () {
                return new GetterGamesExternalEspn(
                    new EspnApiClient()
                );
        });
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
