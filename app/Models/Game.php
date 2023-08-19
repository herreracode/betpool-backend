<?php

namespace App\Models;

use App\Events\CreatedPool;
use App\Events\UpdatedGameResult;
use App\Models\Common\AggregateRoot;
use App\Models\Common\Contracts\Scorable;
use App\Models\Common\Traits\HasScore;
use App\Models\Common\Traits\HasTimestamp;
use App\Models\Enums\GameStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Game Model
 *
 * @property Score $score
 * @property Team $awayTeam
 * @property Team $localTeam
 * @property $status
 * @property $date_start
 * @property $external_api_id_espn
 */
class Game extends AggregateRoot implements Scorable
{
    use HasFactory, HasTimestamp, HasScore;

    const MINUTES_DIFFERENCE_GAME_TO_START = 30;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'local_team_id',
        'away_team_id',
        'date_start',
    ];

    /**
     * Get the competition owns the CompetitionPhase.
     */
    public function competitionPhase()
    {
        return $this->belongsTo(CompetitionPhase::class);
    }

    public function localTeam()
    {
        return $this->belongsTo(Team::class, 'local_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function poolRounds()
    {
        return $this->belongsToMany(PoolRound::class,'pool_round_games');
    }

    /**
     * @param int $localTeamScore
     * @param int $awayTeamScore
     * @return Score
     * @throws \Exception
     */
    public function updateGameResult(int $localTeamScore, int $awayTeamScore): Score
    {
        $Score = $this->score()->create([
            'local_team_score' => $localTeamScore,
            'away_team_score' => $awayTeamScore,
        ]);

        if (!$Score) {
            throw new \Exception('dont create Score');
        }

        $this->finish();

        $this->record(new UpdatedGameResult($this));

        return $Score;
    }

    public function itIsPending()
    {
        return $this->status == GameStatus::PENDING->value;
    }

    public function itIsInProgress()
    {
        return $this->status == GameStatus::IN_PROGRESS->value;
    }

    public function itIsFinished()
    {
        return $this->status == GameStatus::FINISH->value;
    }

    public function itIsPostponed()
    {
        return $this->status == GameStatus::POSTPONED->value;
    }

    public function isAboutToStart(\DateTime $dateTime): bool
    {
        if(!($this->date_start instanceof \DateTime))
            $dateStart = new \DateTime($this->date_start);
        else 
            $dateStart = $this->date_start;

        return $dateStart->diff($dateTime)->i >= static::MINUTES_DIFFERENCE_GAME_TO_START;
    }

    protected function finish()
    {
        $this->status = GameStatus::FINISH->value;

        $this->save();
    }

    public function getLocalTeam(): Team
    {
        return $this->localTeam;
    }

    public function getAwayTeam(): Team
    {
        return $this->awayTeam;
    }

    public function addAditionalData(array $data)
    {
        foreach ($data as $key => $value)
            $this->setAttribute($key, $value);

        return $this->save();
    }
}
