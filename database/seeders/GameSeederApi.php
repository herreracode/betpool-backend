<?php

namespace Database\Seeders;

use App\Actions\Game\Command\CreateGameCommand;
use App\Actions\Game\CreateGame;
use App\Actions\Team\FindOrCreateTeam;
use App\Models\Competition;
use Illuminate\Support\Facades\Http;

class GameSeederApi extends \Illuminate\Database\Seeder
{
    public function run()
    {
        $CreateGame = app(CreateGame::class);
        $FindOrCreateTeam = app(FindOrCreateTeam::class);

        $slug = 'eng.1';

        $Competition = Competition::where([
            'key_external_api' => $slug
        ])->first();

        $keyExternalApi = $Competition->key_external_api;

        //$json = Http::get("https://site.api.espn.com/apis/site/v2/sports/soccer/{$keyExternalApi}/scoreboard?dates=20230426")
        //   ->json();

        $json = json_decode(file_get_contents(__DIR__ . '/json/espnResponseTest.json', true), true);

        foreach ($json['events'] as $event) {

            var_dump($event['status']['type']['name']);

            foreach ($event['competitions'][0]['competitors'] as $competitors) {

                $teams[$competitors['homeAway']] = [
                    'name' => $competitors['team']['name'],
                    'score' => $competitors['score'],
                    'winner' => $competitors['winner'],
                    'abbreviation' => $competitors['team']['abbreviation'],
                ];
            }

            $localTeamArray = collect($teams)
                ->filter(fn($teamArraykey, $value) => $value == 'home')
                ->pop();

            $awayTeamArray = collect($teams)
                ->filter(fn($teamArraykey, $value) => !($value == 'home'))
                ->pop();

            //deben ser findOrCreate por abreviatura
            $LocalTeam = $FindOrCreateTeam->__invoke(
                $localTeamArray['name'],
                $localTeamArray['abbreviation']
            );

            //deben ser findOrCreate por abreviatura
            $AwayTeam = $FindOrCreateTeam->__invoke(
                $awayTeamArray['name'],
                $awayTeamArray['abbreviation']
            );

            $Command = new CreateGameCommand(
                competitionPhaseId:$Competition->competitionPhases->first()->id,
                localTeamId: $LocalTeam->id,
                awayTeamId: $AwayTeam->id,
                dateStartGame: ( new \DateTime($event['date']))->format('Y-m-d H:i:s'),
                externalApiIdEspn: $event['id']
            );

            $Game = $CreateGame->__invoke(
                $Command
            );
        }
    }
}
