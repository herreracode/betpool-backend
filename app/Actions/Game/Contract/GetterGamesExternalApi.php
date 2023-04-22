<?php

namespace App\Actions\Game\Contract;

use App\Actions\Game\RequestGetterGamesExternalApi;

interface GetterGamesExternalApi
{
    public function get(RequestGetterGamesExternalApi $requestGetterGamesExternalApi): array;
}
