<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetitionPhase extends Model
{
    use HasFactory;

    /**
     * Get the competition owns the CompetitionPhase.
     */
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }
}
