<?php

namespace App\Http\Clients;

use App\Http\Clients\Common\ApiClient;
use App\Models\Competition;
use Illuminate\Support\Facades\Http;

class EspnApiClient implements ApiClient
{
    private const BASE_PATH = 'https://site.api.espn.com/apis/site/v2/sports/soccer/';

    protected $route = [
      'scoreboard'
    ];

    /**
     * @param Competition $Competition
     * @param $dateToSearch
     * @return array
     */
    public function get(Competition $Competition, $dateToSearch) : array
    {
        $basePath = static::BASE_PATH;

        return Http::get("{$basePath}{$Competition->keyExternalApi}/scoreboard?dates={$dateToSearch}")
            ->json();
    }

}
