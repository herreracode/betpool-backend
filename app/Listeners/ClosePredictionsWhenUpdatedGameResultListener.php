<?php

namespace App\Listeners;

use App\Events\CreatedPool;
use App\Events\UpdatedGameResult;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ClosePredictionsWhenUpdatedGameResultListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * The name of the connection the job should be sent to.
     *
     * @var string|null
     */
    public $connection = 'databases';

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
    public function handle(UpdatedGameResult $event)
    {
        //obtener el game del evento $event->getAggregate()

        //buscar las predicciones para cerrar

        //deben estar paginadas. de 50 en 50 para no forzar la memoria ni la BD con un query abierto.

        //ver la posibilidad de hacer las busquedas con el query builder para no cargar los modelos.
        // aunque con la paginacion estariamos blindando ese escenario de memoria)

        //en caso de hacer las busquedas con el query builder, utilizar un repositorio.

        // realizar unn $Prediction->close($calculateNumberOfPointsEarned)

        return $event->getAggregate();
    }
}
