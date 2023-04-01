<?php

namespace App\Models\Common\Contracts;

use App\Models\Team;

interface Scorable
{
    public function getLocalTeamScore(): int;

    public function getAwayTeamScore(): int;

    public function getTeamWinner(): Team|null;

    public function getTeamLooser(): Team|null;

    public function getLocalTeam(): Team;

    public function getAwayTeam(): Team;

}
