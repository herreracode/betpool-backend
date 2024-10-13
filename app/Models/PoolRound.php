<?php

namespace App\Models;

use App\DomainServices\Prediction\CalculateNumberOfPointsEarned;
use App\Models\Enums\PoolRoundStatus;
use Betpool\Pool\Domain\Pool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * PoolRound Model
 *
 * @property string $status
 * @property \Illuminate\Database\Eloquent\Collection $predictions
 */
class PoolRound extends Model
{
    use HasFactory;

    /**
     * get Pools user
     */
    public function games()
    {
        return $this->belongsToMany(Game::class,'pool_round_games');
    }

    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }

    public function predictions()
    {
        return $this->hasMany(Prediction::class);
    }

    public function closePredictions(Game $Game, CalculateNumberOfPointsEarned $calculateNumberOfPointsEarned) :PoolRound
    {
        $predictionsByGame = $this->getPredictionsByGame($Game);

        $predictionsByGame
            ->each(fn(Prediction $Prediction) => $Prediction->close($calculateNumberOfPointsEarned));

        $this->finish();

        return $this;
    }

    public function cancelPredictions(Game $Game)
    {
        $predictionsByGame = $this->getPredictionsByGame($Game);

        $predictionsByGame
            ->each(fn(Prediction $Prediction) => $Prediction->cancel());

        $this->finish();

        return $this;
    }

    protected function getPredictionsByGame(Game $Game): Collection
    {
        return $this->predictions
            ->filter(fn (Prediction $Prediction) => $Prediction->game->id == $Game->id);
    }

    protected function getDistinctPredictionStatus() : Collection
    {
        return $this->predictions
            ->pluck('status')
            ->unique();
    }

    protected function IsEmptyPrediction()
    {
        return $this->predictions->count() == 0;
    }

    protected function finish()
    {
        $predictionsStatus = $this->getDistinctPredictionStatus();

        $allPredictionsInStatusValidForFinish = !in_array('_PENDING_',$predictionsStatus->toArray());

        if (($allPredictionsInStatusValidForFinish || $this->IsEmptyPrediction()) && $this->status !== PoolRoundStatus::FINISH->value){

            $this->status = PoolRoundStatus::FINISH->value;

            $this->save();

        }
    }
}
