<?php

namespace App\Actions\Game;

use App\Actions\Game\Command\CreateGameCommand;
use App\Models\CompetitionPhase;
use App\Models\Game;
use App\Models\Team;
use Exception;

/**
 * Class CreateGame
 */
class CreateGame
{
    public function __invoke2(
           CompetitionPhase $CompetitionPhase,
           Team $LocalTeam,
           Team $AwayTeam,
           \DateTime $DateStartGame
    ): Game
    {
        return $CompetitionPhase->addGame($LocalTeam, $AwayTeam, $DateStartGame);
    }

    public function __invoke(
          CreateGameCommand $CreateGameCommand
    ): Game
    {
        $LocalTeam = Team::where([
            'id' => $CreateGameCommand->localTeamId
        ])->first();

        $AwayTeam = Team::where([
            'id' => $CreateGameCommand->awayTeamId
        ])->first();

        $CompetitionPhase = CompetitionPhase::where([
            'id' => $CreateGameCommand->competitionPhaseId
        ])->first();

        return $CompetitionPhase->addGame(
            $LocalTeam,
            $AwayTeam,
            new \DateTime($CreateGameCommand->dateStartGame)
        );
    }
}
