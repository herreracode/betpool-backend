<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 */
class CompetitionPhase extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the competition owns the CompetitionPhase.
     */
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function addGame(Team $LocalTeam, Team $AwayTeam, \DateTime $DateStartGame) : Game
    {
        $Game = $this->games()->create([
            'local_team_id' => $LocalTeam->id,
            'away_team_id' => $AwayTeam->id,
            'date_start' => $DateStartGame->format('Y-m-d H:i:s')
        ]);

        if (! $Game) {
            throw new \Exception('dont save Game');
        }

        return $Game;
    }
}
