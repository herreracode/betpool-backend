<?php

namespace App\Actions\Game;

use App\Models\Competition;

class RequestGetterGamesExternalApi
{

    public function __construct(
        public Competition $Competition,
        public string $dateToSearch
    ){
    }
}
