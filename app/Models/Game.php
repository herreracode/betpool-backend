<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Game Model
 *
 * @property Score $score
 */
class Game extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'local_team_id',
        'away_team_id',
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

    /**
     * Get all of the post's comments.
     */
    public function score()
    {
        return $this->morphOne(Score::class, 'scorable');
    }
}
