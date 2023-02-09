<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use HasFactory;

    /**
     * Get the competitionPhases
     */
    public function competitionPhases()
    {
        return $this->hasMany(CompetitionPhase::class);
    }
}
