<?php

namespace App\Models\Common\Traits;

use App\Models\Score;
use App\Models\Team;

/**
 * @property Score $score
 */
trait HasScore
{
    /**
     * Get all of the post's comments.
     */
    public function score()
    {
        return $this->morphOne(Score::class, 'scorable');
    }

    public function getLocalTeamScore() :int
    {
        return $this->score->getLocalTeamScore();
    }

    public function getAwayTeamScore() :int
    {
        return $this->score->getAwayTeamScore();
    }

    public function getTeamWinner(): Team|null
    {
        return $this->getLocalTeamScore() > $this->getAwayTeamScore()
            ? $this->getLocalTeam()
            : ($this->getAwayTeamScore() > $this->getLocalTeamScore()
            ? $this->getAwayTeam()
            : null);
    }

    public function getTeamLooser(): Team|null
    {
        return !$this->getLocalTeamScore() > $this->getAwayTeamScore()
            ? $this->getLocalTeam()
            : (!$this->getAwayTeamScore() > $this->getLocalTeamScore()
                ? $this->getAwayTeam()
                : null);
    }

}
