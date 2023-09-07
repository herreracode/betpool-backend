<?php

namespace App\Models;

use App\DomainServices\Prediction\CalculateNumberOfPointsEarned;
use App\Models\Enums\PoolRoundStatus;
use App\Models\Enums\PredictionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        $predictionsByGame = $this->predictions
        ->filter(fn (Prediction $Prediction) => $Prediction->game->id == $Game->id);

        $predictionsByGame
            ->each(fn(Prediction $Prediction) => $Prediction->close($calculateNumberOfPointsEarned));

        $predictionsStatus = $this->predictions
        ->pluck('status')
        ->unique();

        $allPredictionsInStatusClose = $predictionsStatus->count() == 1 &&  $predictionsStatus->first() == PredictionStatus::CLOSE->value;

        $emptyPredictions = $this->predictions->count() == 0;

        //validate all predictions state in finish
        if (($allPredictionsInStatusClose || $emptyPredictions) && $this->status !== PoolRoundStatus::FINISH->value)
            $this->finish();

        return $this;
    }

    protected function finish()
    {
        $this->status = PoolRoundStatus::FINISH->value;

        $this->save();
    }
}
