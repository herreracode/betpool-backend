<?php

namespace Database\Seeders;

use App\Models\CompetitionPhase;
use App\Models\Game;
use App\Models\Team;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $CompetitionPhase = CompetitionPhase::all()->first();

        Game::factory()
            ->count(3)
            ->for($CompetitionPhase)
            ->for(
                Team::factory()->create(), 'localTeam'
            )->for(
                Team::factory()->create(), 'awayTeam'
            )
            ->create();
    }
}
