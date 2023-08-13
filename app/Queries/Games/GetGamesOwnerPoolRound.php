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

            $array = [
                'team_away' => $Game->awayTeam->name,
                'team_local' => $Game->localTeam->name,
                'description' => $Game->localTeam->name.' vs '.$Game->awayTeam->name,
            ];


            $keysOnly = $Game->only([
                'status',
                'date_start',
                'id',
            ]);

            return array_merge($array, $keysOnly);
        };
    }
}