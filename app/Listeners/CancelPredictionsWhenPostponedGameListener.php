<?php

namespace App\Listeners;

use App\Actions\PoolRound\CancelPredictionsByPoolRoundAndGame;
use App\Actions\PoolRound\ClosePredictionsByPoolRoundAndGame;
use App\Actions\Prediction\ClosePrediction;
use App\Events\CreatedPool;
use App\Events\UpdatedGameResult;
use App\Models\PoolRound;
use App\Models\Prediction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CancelPredictionsWhenPostponedGameListener implements ShouldQueue
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
    public function __construct(protected CancelPredictionsByPoolRoundAndGame $cancelPredictionsByPoolRoundAndGame)
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

        //TODO: PAGINATION TO MANAGE DATA HIGH VOLUME
        $page = 1;

        $PoolRounds = $Game->poolRounds;

        $PoolRounds
            ->each(fn(PoolRound $poolRound) => $this->cancelPredictionsByPoolRoundAndGame->__invoke($poolRound, $Game));
    }
}
