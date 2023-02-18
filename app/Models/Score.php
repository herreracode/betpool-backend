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

    public function scorable()
    {
        return $this->morphTo();
    }
}
