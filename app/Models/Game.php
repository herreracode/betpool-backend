<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    /**
     * Get the competition owns the CompetitionPhase.
     */
    public function competitionPhase()
    {
        return $this->belongsTo(CompetitionPhase::class);
    }

    /**
     * 
     */
    public function localTeam()
    {
        return $this->belongsTo(Team::class, 'local_team_id');
    }
    
    /**
     * 
     */
    public function awayTeam()
    {
        return $this->belongsTo(Team::class,'away_team_id');
    }
}
