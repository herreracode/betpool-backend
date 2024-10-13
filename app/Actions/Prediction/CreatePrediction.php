<?php

namespace App\Actions\Prediction;

use App\Exceptions\Prediction\ExistsPrediction;
use App\Models\{Game, PoolRound, Prediction, User};
use Betpool\Pool\Domain\Pool;

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
        $existPrediction = Prediction::where([
            'game_id'       => $Game->id,
            'user_id'       => $User->id,
            'pool_round_id' => $PoolRound->id,
        ])->count() > 0;

        if($existPrediction){
            throw ExistsPrediction::create("already exist prediction of that game");
        }

        return Prediction::createWithValidations(
            $User,
            $Pool,
            $Game,
            $PoolRound,
            $localTeamScore,
            $awayTeamScore,
            $dateCreatePrediction);
    }

}
