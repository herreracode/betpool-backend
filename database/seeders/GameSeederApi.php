<?php

namespace Database\Seeders;

use App\Actions\Game\CreateGame;
use App\Actions\Team\CreateTeam;
use App\Models\Competition;
use Illuminate\Support\Facades\Http;

class GameSeederApi extends \Illuminate\Database\Seeder
{
    public function run()
    {
        $CreateGame = app(CreateGame::class);
        $CreateTeam = app(CreateTeam::class);

        $slug = 'eng.1';

        $Competition = Competition::where([
            'key_external_api' => $slug
        ])->first();

        $keyExternalApi = $Competition->key_external_api;

        $json = Http::get("https://site.api.espn.com/apis/site/v2/sports/soccer/{$keyExternalApi}/scoreboard?dates=20230426")
            ->json();

        $array = [];

        foreach ($json['events'] as $event) {

            var_dump($event['status']['type']['name']);

            foreach ($event['competitions'][0]['competitors'] as $competitors) {

                $teams[$competitors['homeAway']] = [
                    'name' => $competitors['team']['name'],
                    'score' => $competitors['score'],
                    'winner' => $competitors['winner'],
                ];
            }

            $localTeamArray = collect($teams)
                ->filter(fn($teamArraykey, $value) => $value == 'home')
                ->pop();

            $awayTeamArray = collect($teams)
                ->filter(fn($teamArraykey, $value) => !($value == 'home'))
                ->pop();

            //deben ser findOrCreate por abreviatura
            $LocalTeam = $CreateTeam->__invoke(
                $localTeamArray['name']
            );

            //deben ser findOrCreate por abreviatura
            $AwayTeam = $CreateTeam->__invoke(
                $awayTeamArray['name']
            );

            $Game = $CreateGame->__invoke(
                $Competition->competitionPhases->first(),
                $LocalTeam,
                $AwayTeam,
                new \DateTime()
            );
        }
    }
}
