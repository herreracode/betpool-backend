<?php

namespace Database\Seeders;

use App\Models\Competition;
use Illuminate\Support\Facades\Http;

class PredictiondsSeederApi extends \Illuminate\Database\Seeder
{
    public function run()
    {
        $slug = 'eng.1';

        $Competition = Competition::where([
            'key_external_api' => $slug
        ])->first();

        $json = Http::get("https://site.api.espn.com/apis/site/v2/sports/soccer/{$Competition->key_external_api}/scoreboard?dates=20230409")
            ->json();

        $array = [];

        foreach ($json['events'] as $event){

            var_dump($event['status']['type']['name']);

            $teams = [];

            foreach($event['competitions'][0]['competitors'] as $competitors){

                $teams[$competitors['homeAway']] = [
                    'name' => $competitors['team']['name'],
                    'score' => $competitors['score'],
                    'winner' => $competitors['winner'],
                ];
            }

            dd($teams);

            dd("asdas");
            $array[] = $event;
        }
    }
}
