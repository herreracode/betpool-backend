<?php

namespace Database\Seeders;

use App\Actions\Competition\CreateCompetition;
use App\Actions\Competition\CreateCompetitionPhase;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CompetitionSeederApi extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $CreateCompetition = app(CreateCompetition::class);
        $CreateCompetitionPhase = app(CreateCompetitionPhase::class);

        foreach (["eng.1", "esp.1"] as $slugLeague){

            $array = Http::get("https://site.api.espn.com/apis/site/v2/sports/soccer/{$slugLeague}/teams")
                ->json();

            $leagueInfo = $array['sports'][0]['leagues'][0];

            $Competition = $CreateCompetition($leagueInfo['name'], $leagueInfo['slug']);

            $CreateCompetitionPhase->__invoke($Competition, 'Jornada');

        }

    }
}
