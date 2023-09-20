<?php

namespace App\Queries\Games;

use App\Models\Game;
use App\Models\PoolRound;
use App\Models\User;
use App\Models\Enums\GameStatus;

class GetGamesOwnerPoolRound
{
    public function __invoke(
        User $User,
        PoolRound $PoolRound,
    ) :array {

        $gamesFormat = $games = [];

            $gamesFormat = $PoolRound
            ->games
            ->map($this->mapGamesWithData()
            )->toArray();

            $games = array_merge($games, $gamesFormat);

        return $games;
    }


    protected function mapGamesWithData()
    {

        return function (Game $Game) {

            $Score = $Game->score;

            $array = [
                'team_away' => $Game->awayTeam->name,
                'score_away' => $Score ? $Score->getAwayTeamScore() : '',
                'team_local' => $Game->localTeam->name,
                'score_local' => $Score ? $Score->getLocalTeamScore() : '',
                'description' => $Game->localTeam->name.' vs '.$Game->awayTeam->name,
                'date_start' => (new \DateTime($Game->date_start))->format('Y-m-d\TH:i:s\Z'),
            ];


            $keysOnly = $Game->only([
                'status',
                'id',
            ]);

            return array_merge($array, $keysOnly);
        };
    }
}
