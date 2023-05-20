<?php

namespace Tests\Unit\Game;

use App\Actions\Game\CreateGame;
use App\Actions\Game\CreateGamesForExternalApi;
use App\Actions\Team\FindOrCreateTeam;
use App\Http\Clients\Common\ApiClient;
use App\InfrastructureServices\GetterGamesExternalEspn;
use App\Models\Competition;
use App\Models\CompetitionPhase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Tests\TestCase;

class CreateGameForExternalApiTest extends TestCase
{
    use RefreshDatabase;
    use WithoutEvents;

    protected function setUp(): void
    {
        parent::setup();
    }

    public function testHappyPath()
    {
        $ApiClient = $this->createMock(ApiClient::class);

        $json = json_decode(file_get_contents(__DIR__ . '/json/espnResponseTest.json', true), true);

        $ApiClient
            ->method('get')
            ->willReturn($json);

        $GetterGamesExternalApi = new GetterGamesExternalEspn($ApiClient);

        $this->CreateGameForExternalApi = new CreateGamesForExternalApi(
            $GetterGamesExternalApi,
            app(FindOrCreateTeam::class),
            app(CreateGame::class),
        );

        $Competition = Competition::factory([
            'name'             => 'English premier league',
            'key_external_api' => 'eng.1',
        ])->create();

        CompetitionPhase::factory()->for($Competition)->create();

        $Games = $this
            ->CreateGameForExternalApi
            ->__invoke($Competition, (new \DateTime())->format('Y-m-d H:i:s'));

        $this->assertNotEmpty($Games);
    }

}
