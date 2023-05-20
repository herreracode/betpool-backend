<?php

namespace App\InfrastructureServices;

use App\Actions\Game\Contract\GetterGamesExternalApi;
use App\Actions\Game\RequestGetterGamesExternalApi;
use App\Actions\Game\ResponseGetterGamesExternalApi;
use App\Http\Clients\Common\ApiClient;

class GetterGamesExternalEspn implements GetterGamesExternalApi
{
    public function __construct(protected ApiClient $ApiClient)
    {
    }

    public function get(RequestGetterGamesExternalApi $requestGetterGamesExternalApi): array
    {
        $Competition = $requestGetterGamesExternalApi->Competition;
        $dateToSearch = $requestGetterGamesExternalApi->dateToSearch;

        $json = $this->ApiClient->get($Competition, $dateToSearch);

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

            $Response->setDataLocalTeam($localTeamArray);
            $Response->setDataAwayTeam($awayTeamArray);

            $Response->setDataStartGame($event['date']);
            $Response->setDataAditional([
                'external_api_id_espn' => $event['id']
            ]);

            $finalResponse[] = $Response;
        }

        return $finalResponse;
    }
}
