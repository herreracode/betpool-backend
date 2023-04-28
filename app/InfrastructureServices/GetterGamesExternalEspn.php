<?php

namespace App\InfrastructureServices;

use App\Actions\Game\Contract\GetterGamesExternalApi;
use App\Actions\Game\RequestGetterGamesExternalApi;
use App\Actions\Game\ResponseGetterGamesExternalApi;
use Illuminate\Support\Facades\Http;

class GetterGamesExternalEspn implements GetterGamesExternalApi
{
    public function get(RequestGetterGamesExternalApi $requestGetterGamesExternalApi): array
    {
        $Competition = $requestGetterGamesExternalApi->Competition;
        $dateToSearch = $requestGetterGamesExternalApi->dateToSearch;

        $json = Http::get("https://site.api.espn.com/apis/site/v2/sports/soccer/{$Competition->keyExternalApi}/scoreboard?dates={$dateToSearch}")
           ->json();

        foreach ($json['events'] as $event) {

            $Response = new ResponseGetterGamesExternalApi();

            $Response->setStatus($event['status']['type']['name']);

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

            $Response->setDataLocalTeam();
            $Response->setDataAwayTeam([]);

            $Response->setDataStartGame($event['date']);
            $Response->setDataAditional([
                'external_api_id_espn' => $event['id']
            ]);

            $finalResponse[] = $Response;
        }

        return $finalResponse;
    }
}
