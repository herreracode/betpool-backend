<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Competition
 *
 *
 * @property string name
 * @property bool must_be_unique
 */
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
