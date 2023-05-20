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

    public function __invoke(Competition $Competition, $dateToSearch): array{

        $RequestGetterGamesExternalApi = new RequestGetterGamesExternalApi(
            Competition: $Competition,
            dateToSearch: $dateToSearch
        );

        $arrayResponses = $this->GetterGamesExternalApi->get($RequestGetterGamesExternalApi);

        foreach ($arrayResponses as $Response) {

            $localTeamData = $Response->getDataLocalTeam();

            $awayTeamData = $Response->getDataAwayTeam();

            //must be findOrCreate by Abbreviation
            $LocalTeam = $this->FindOrCreateTeam->__invoke(
                data_get($localTeamData,'name'),
                data_get($localTeamData,'abbreviation')
            );

            //must be findOrCreate by Abbreviation
            $AwayTeam = $this->FindOrCreateTeam->__invoke(
                data_get($awayTeamData,'name'),
                data_get($awayTeamData,'abbreviation')
            );

            $Command = new CreateGameCommand(
                competitionPhaseId: $Competition->competitionPhases->first()->id,
                localTeamId: $LocalTeam->id,
                awayTeamId: $AwayTeam->id,
                dateStartGame: ( new \DateTime($Response->getDataStartGame()))->format('Y-m-d H:i:s'),
                externalApiIdEspn: data_get($Response->getDataAditional(),'external_api_id_espn')
            );

            $Games[] = $this->CreateGame->__invoke(
                $Command
            );
        }

        return $Games;
    }
}
