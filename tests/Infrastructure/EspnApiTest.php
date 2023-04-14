<?php

namespace Tests\Infrastructure;

use App\Actions\Game\CreateGame;
use App\Models\Competition;
use App\Models\CompetitionPhase;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class EspnApiTest extends TestCase
{
    use RefreshDatabase;
    use WithoutEvents;

    protected function setUp(): void
    {
        parent::setup();


    }

    public function testCreateGame()
    {
        $json = Http::get('https://site.api.espn.com/apis/site/v2/sports/soccer/eng.1/scoreboard?dates=20230409')
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

        dd($array);

        $this->assertJson($json);
    }
}
