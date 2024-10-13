<?php

namespace App\Queries\Games;

use App\Models\Enums\GameStatus;
use App\Models\Game;
use App\Models\User;
use Betpool\Pool\Domain\Pool;

class GetGamesForPoolRound
{
    public function __invoke(
        User $User,
        Pool $Pool,
    ) :array {

        $Competitions = $Pool->competitions;
        $gamesFormat = $games = [];

        foreach($Competitions as $Competition){

            $gamesFormat = $Competition
            ->competitionPhases
            ->first()
            ->games()
            ->where('status','=', GameStatus::PENDING->value
            )->get()
            ->map($this->mapGamesWithData()
            )->toArray();

            $games = array_merge($games, $gamesFormat);

        }

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
