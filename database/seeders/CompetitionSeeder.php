<?php

namespace Database\Seeders;

use App\Models\Competition;
use Illuminate\Database\Seeder;

class CompetitionSeeder extends Seeder
{
    private const COMPETITIONS = [
        'FIFA WORLD CUP',
        'AMERICAN CUP',
        'EUROPE CUP',
    ];

    private const COMPETITIONS_PHASES = [
        'PHASE GROUP',
        'ROUND OF 16',
        'QUATERS FINALS',
        'SEMI FINALS',
        'FINAL',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (static::COMPETITIONS as $competition) {
            $Competition = new Competition();

            $Competition->name = $competition;

            $Competition->save();

            foreach (static::COMPETITIONS_PHASES as $phase) {
                $Competition->competitionPhases()->create([
                    'name' => $phase,
                ]);
            }
        }
    }
}
