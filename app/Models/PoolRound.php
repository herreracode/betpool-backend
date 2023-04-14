<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoolRound extends Model
{
    use HasFactory;

    /**
     * get Pools user
     */
    public function games()
    {
        return $this->belongsToMany(Game::class,'pool_round_games');
    }

    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }

    public function predictions()
    {
        return $this->hasMany(Prediction::class);
    }
}
