<?php

namespace Database\Seeders;

use App\Models\Competition;
use Illuminate\Database\Seeder;

class CompetitionSeeder extends Seeder
{
    private const COMPETITIONS = [
        [
            'name' => 'Liga Española',
            'key'  => 'esp.1',
        ],
        [
            'name' => 'Liga Inglesa',
            'key'  => 'eng.1',
        ],
    ];

    private const COMPETITION_PHASE = 'Jornada';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (static::COMPETITIONS as $competition) {
            $Competition = new Competition();

            $Competition->name = $competition['name'];
            $Competition->key_external_api = $competition['key'];

            $Competition->save();

            $Competition->competitionPhases()->create([
                'name' => static::COMPETITION_PHASE,
            ]);
        }
    }
}
