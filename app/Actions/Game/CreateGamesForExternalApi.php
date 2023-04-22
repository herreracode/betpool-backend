<?php

namespace App\Actions\Game;

use App\Actions\Game\Command\CreateGameCommand;
use App\Actions\Game\Contract\GetterGamesExternalApi;
use App\Actions\Team\FindOrCreateTeam;
use App\Models\Competition;

class CreateGamesForExternalApi
{

    public function __construct(
        protected GetterGamesExternalApi $GetterGamesExternalApi,
        protected FindOrCreateTeam $FindOrCreateTeam,
        protected CreateGame $CreateGame,
    ){
    }

    public function __invoke(Competition $Competition, $dateToSearch){

        $RequestGetterGamesExternalApi = new RequestGetterGamesExternalApi(
            Competition: $Competition,
            dateToSearch: $dateToSearch
        );

        $arrayResponses = $this->GetterGamesExternalApi->get($RequestGetterGamesExternalApi);

        foreach ($arrayResponses as $Response) {

            $localTeamData = $Response->getDataLocalTeam();

            $awayTeamData = $Response->getDataAwayTeam();

            //deben ser findOrCreate por abreviatura
            $LocalTeam = $this->FindOrCreateTeam->__invoke(
                $localTeamData->name,
                $localTeamData->abbreviation
            );

            //deben ser findOrCreate por abreviatura
            $AwayTeam = $this->FindOrCreateTeam->__invoke(
                $awayTeamData->name,
                $awayTeamData->abbreviation
            );

            $Command = new CreateGameCommand(
                competitionPhaseId: $Competition->competitionPhases->first()->id,
                localTeamId: $LocalTeam->id,
                awayTeamId: $AwayTeam->id,
                dateStartGame: ( new \DateTime($Response->getDataStartGame()))->format('Y-m-d H:i:s'),
                externalApiIdEspn: $Response->getDataAditional()->external_api_id_espn
            );

            $Game = $this->CreateGame->__invoke(
                $Command
            );
        }
    }
}
