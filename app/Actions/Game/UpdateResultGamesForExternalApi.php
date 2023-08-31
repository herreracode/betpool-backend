<?php

namespace App\Actions\Game;

use App\Actions\Game\Contract\GetterGamesExternalApi;
use App\Actions\Team\FindOrCreateTeam;
use App\Models\Competition;
use App\Models\Game;
use App\Models\Team;

class UpdateResultGamesForExternalApi
{

    public function __construct(
        protected GetterGamesExternalApi $GetterGamesExternalApi,
        protected FindOrCreateTeam $FindOrCreateTeam,
        protected UpdateGameResult $UpdateGameResult,
    ){
    }

    public function __invoke(Competition $Competition, $dateToSearch)
    {
        $RequestGetterGamesExternalApi = new RequestGetterGamesExternalApi(
            Competition: $Competition,
            dateToSearch: $dateToSearch
        );

        $arrayResponses = $this->GetterGamesExternalApi->get($RequestGetterGamesExternalApi);

        $Games = [];

        foreach ($arrayResponses as $Response) {

            if(!($Response->status ==  "STATUS_FULL_TIME")){
                continue;
            }

            $localTeamData = $Response->getDataLocalTeam();

            $awayTeamData = $Response->getDataAwayTeam();

            $LocalTeam = Team::where([
                'abbreviation' => data_get($localTeamData,'abbreviation')
            ])->first();

            $AwayTeam = Team::where([
                'abbreviation' => data_get($awayTeamData,'abbreviation')
            ])->first();

            $Games[] = $Game = Game::where([
                'local_team_id' => $LocalTeam->id,
                'away_team_id' => $AwayTeam->id,
                'competition_phase_id' => $Competition->competitionPhases->first()->id,
            ])->first();

            $Game && $this->UpdateGameResult->__invoke(
                $Game, data_get($localTeamData,'score'), data_get($awayTeamData,'score')
            );
        }

        return $Games;
    }
}
