<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Competition
 *
 *
 * @property string $name
 * @property bool   $must_be_unique
 * @property string $keyExternalApi
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

    /**
     * @param $name
     * @return static
     * @throws \Exception
     */
    public static function create($name, $externalApiKey) :static
    {
        $Competition = new static();

        $Competition->name = $name;
        $Competition->key_external_api = $externalApiKey;

        if (! $Competition->save()) {
            throw new \Exception('dont save competition');
        }

        return $Competition;
    }

    public function addCompetitionPhase($name) : CompetitionPhase
    {
        $CompetitionPhase = $this->competitionPhases()->create([
            'name' => $name,
        ]);

        if (! $CompetitionPhase) {
            throw new \Exception('dont save competition phase');
        }

        return $CompetitionPhase;
    }
}
