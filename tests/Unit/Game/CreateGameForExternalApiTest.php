<?php

namespace Tests\Unit\Game;

use App\Actions\Game\Contract\GetterGamesExternalApi;
use App\Actions\Game\CreateGame;
use App\Actions\Game\CreateGamesForExternalApi;
use App\Actions\Team\FindOrCreateTeam;
use App\Models\Competition;
use Database\Factories\CompetitionFactory;
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
        $GetterGamesExternalApi = $this->createMock(GetterGamesExternalApi::class);

        $json = json_decode(file_get_contents(__DIR__ . '/json/espnResponseTest.json', true), true);

        $GetterGamesExternalApi
            ->method('get')
            ->willReturn($json);

        $this->CreateGameForExternalApi = new CreateGamesForExternalApi(
            $GetterGamesExternalApi,
            app(FindOrCreateTeam::class),
            app(CreateGame::class),
        );

        $Competition = Competition::factory([
            'name'             => 'English premier league',
            'key_external_api' => 'eng.1',
        ])->create();

        $this
            ->CreateGameForExternalApi
            ->__invoke($Competition, (new \DateTime())->format('Y-m-d H:i:s'));
    }

}
