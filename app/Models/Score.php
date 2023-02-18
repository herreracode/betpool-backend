<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $local_team_score
 */
class Score extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'local_team_score',
        'away_team_score',
    ];

    public function scorable()
    {
        return $this->morphTo();
    }

    public function getLocalTeamScore(){

        return $this->local_team_score;
    }
    
    public function getAwayTeamScore(){

        return $this->away_team_score;
    }
}
