<?php

namespace Database\Seeders;

use App\Models\CompetitionPhase;
use App\Models\Game;
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
            ->create();
    }
}
