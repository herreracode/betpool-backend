<?php

namespace App\Models;

use App\Exceptions\Prediction\GameIsAboutToStart;
use App\Exceptions\Prediction\GameIsNotFinishedToClosePrediction;
use App\Exceptions\Prediction\GameIsNotStateValid;
use App\Models\Enums\PredictionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Score $score
 * @property Game $Game
 * @property int $pool_id
 * @property int $game_id
 * @property int $user_id
 * @property int $status
 */
class Prediction extends Model
{
    use HasFactory;

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

    /**
     * Get all of the post's comments.
     */
    public function score()
    {
        return $this->morphOne(Score::class, 'scorable');
    }

    public function getLocalTeamScore()
    {
        return $this->score->getLocalTeamScore();
    }

    public function getAwayTeamScore()
    {
        return $this->score->getAwayTeamScore();
    }

    public static function createWithValidations(
        User $User,
        Pool $Pool,
        Game $Game,
        int $localTeamScore,
        int $awayTeamScore,
        \DateTime $dateTimeCreate = new \DateTime(),
    ): static
    {

        //validations
        $Pool->doesItbelongsToThePool($User);

        if(!$Game->itIsPending())
            throw GameIsNotStateValid::create("game is not state pending");

        if($Game->isAboutToStart($dateTimeCreate))
            throw GameIsAboutToStart::create("game is about to start");

        $Prediction = new static();

        $Prediction->user_id = $User->id;
        $Prediction->pool_id = $Pool->id;
        $Prediction->game_id = $Game->id;
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

    public function close()
    {
        if(!$this->Game->itIsFinished())
            throw GameIsNotFinishedToClosePrediction::create('Game is not finished to close prediction');

        $this->status = PredictionStatus::CLOSE->value;

        $this->save();
    }
}
