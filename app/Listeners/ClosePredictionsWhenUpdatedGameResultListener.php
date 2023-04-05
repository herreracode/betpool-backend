<?php

namespace App\Listeners;

use App\Actions\Prediction\ClosePrediction;
use App\Events\CreatedPool;
use App\Events\UpdatedGameResult;
use App\Models\Prediction;
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
    public function __construct(protected ClosePrediction $ClosePrediction)
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

        $Game = $event->getAggregate();

        //buscar las predicciones para cerrar
        $page = 1;

        do{
            $Predictions = Prediction::where([
                'game_id' => $Game->id
            ])
                ->forPage($page,10)
                ->get();

            $countPredictions = $Predictions->count();

            $Predictions
                ->each(fn (Prediction $prediction) => $this->ClosePrediction->__invoke($prediction));

            $page+= 1;

        }while($countPredictions != 0);
    }
}
