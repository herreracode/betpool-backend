<?php

namespace App\Actions\Prediction;

use App\Models\Game;
use App\Models\Pool;
use App\Models\PoolRound;
use App\Models\Prediction;
use App\Models\User;

class CreatePrediction
{
    public function __construct()
    {
    }

    public function __invoke(
        User $User,
        Pool $Pool,
        Game $Game,
        PoolRound $PoolRound,
        int $localTeamScore,
        int $awayTeamScore,
        \DateTime $dateCreatePrediction = new \DateTime()
    ): Prediction
    {
        $Prediction = Prediction::createWithValidations(
            $User,
            $Pool,
            $Game,
            $PoolRound,
            $localTeamScore,
            $awayTeamScore,
            $dateCreatePrediction);

        return $Prediction;
    }

}
