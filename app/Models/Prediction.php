<?php

namespace App\Models;

use App\DomainServices\Prediction\CalculateNumberOfPointsEarned;
use App\Exceptions\Prediction\GameIsAboutToStart;
use App\Exceptions\Prediction\GameIsNotFinishedToClosePrediction;
use App\Exceptions\Prediction\GameIsNotPostponedToCancelPrediction;
use App\Exceptions\Prediction\GameIsNotStateValid;
use App\Exceptions\Prediction\UserModifierNotOwner;
use App\Models\Common\Contracts\Scorable;
use App\Models\Common\Traits\HasScore;
use App\Models\Enums\PredictionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Score $score
 * @property Game $game
 * @property int $pool_id
 * @property int $game_id
 * @property int $user_id
 * @property int $status
 * @property int $points_earned
 * @property int $pool_round_id
 */
class Prediction extends Model implements Scorable
{
    use HasFactory, HasScore;

    /**
     * get user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * get Pools user
     */
    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }

    /**
     * get game
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function poolRound()
    {
        return $this->belongsTo(PoolRound::class);
    }


    public static function createWithValidations(
        User $User,
        Pool $Pool,
        Game $Game,
        PoolRound $PoolRound,
        int $localTeamScore,
        int $awayTeamScore,
        \DateTime $dateTimeCreate = new \DateTime(),
    ): static
    {

        //validations
        $Pool->doesItbelongsToThePool($User);

        if(!$Game->itIsPending())
            throw GameIsNotStateValid::create("game is not state pending");

        //todo: fixed
        if($Game->isAboutToStart($dateTimeCreate))
            throw GameIsAboutToStart::create("game is about to start");

        $Prediction = new static();

        $Prediction->user_id = $User->id;
        $Prediction->pool_id = $Pool->id;
        $Prediction->game_id = $Game->id;
        $Prediction->pool_round_id = $PoolRound->id;
        $Prediction->setCreatedAt($dateTimeCreate->format('Y-m-d H:i:s'));

        if (! $Prediction->save()) {
            throw new \Exception('dont save competition');
        }

        $Score = new Score();
        $Score->local_team_score = $localTeamScore;
        $Score->away_team_score = $awayTeamScore;

        $Prediction->score()->save($Score);

        return $Prediction;
    }

    public function itIsInPending()
    {
        return $this->status == PredictionStatus::PENDING->value;
    }

    public function itIsInClose()
    {
        return $this->status == PredictionStatus::CLOSE->value;
    }

    public function close(CalculateNumberOfPointsEarned $calculateNumberOfPointsEarned)
    {
        if(!$this->Game->itIsFinished())
            throw GameIsNotFinishedToClosePrediction::create('Game is not finished to close prediction');

        $this->status = PredictionStatus::CLOSE->value;

        $this->points_earned = $calculateNumberOfPointsEarned(
            $this,
            $this->game
        );

        $this->save();
    }

    public function cancel()
    {
        if(!$this->game->itIsPostponed())
            throw GameIsNotPostponedToCancelPrediction::create('Game is not postponed to cancel prediction');

        $this->status = PredictionStatus::CANCEL->value;

        $this->points_earned = 0;

        $this->save();
    }

    public function getLocalTeam(): Team
    {
        return $this->game->localTeam;
    }

    public function getAwayTeam(): Team
    {
        return $this->game->awayTeam;
    }

    public function modify($scoreLocal, $scoreAway, $idUserModifier)
    {
        $Game = $this->game;

        //validate Game finished
        if (!$Game->itIsPending())
            throw GameIsNotStateValid::create("game is not state pending");

        //validate Game has not started yet (isAboutToStart).leave to do at the end

        //validate scores is not the same as before

        //validate user modifier is prediction owner
        if ($this->user_id !== $idUserModifier)
            throw UserModifierNotOwner::create("game is not state pending");

        $this->score->local_team_score = $scoreLocal;

        $this->score->away_team_score = $scoreAway;

        $this->score->save();

        return $this;
    }

}
