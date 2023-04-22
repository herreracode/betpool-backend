<?php

namespace Tests\Unit\Game\Actions;

use App\Actions\Game\Command\CreateGameCommand;
use App\Actions\Game\CreateGame;
use App\Models\Competition;
use App\Models\CompetitionPhase;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Tests\TestCase;

class CreateGameActionTest extends TestCase
{
    use RefreshDatabase;
    use WithoutEvents;

    protected function setUp(): void
    {
        parent::setup();

        $this->CreateGameAction = app(CreateGame::class);
    }

    public function testCreateGame()
    {
        $CompetitionPhase = CompetitionPhase::factory()
        ->for(Competition::factory())
        ->create();

        $LocalTeam = Team::factory()->create();

        $AwayTeam = Team::factory()->create();

        $Command = new CreateGameCommand(
            competitionPhaseId: $CompetitionPhase->id,
            localTeamId: $LocalTeam->id,
            awayTeamId: $AwayTeam->id,
            dateStartGame: (new \DateTime())->format('Y-m-d H:i:s')
        );

        $Game = $this->CreateGameAction->__invoke($Command);

        $this->assertEquals($Game->localTeam->id, $LocalTeam->id);

        $this->assertEquals($Game->awayTeam->id, $AwayTeam->id);

        $this->assertEquals($Game->awayTeam->id, $AwayTeam->id);

        $this->assertEquals($Game->competitionPhase->id, $CompetitionPhase->id);
    }

    public function testCreateGameWithExternalApiKeyEspn()
    {
        $CompetitionPhase = CompetitionPhase::factory()
            ->for(Competition::factory())
            ->create();

        $LocalTeam = Team::factory()->create();

        $AwayTeam = Team::factory()->create();

        $externalApiIdEspn = 12345;

        $Command = new CreateGameCommand(
            competitionPhaseId: $CompetitionPhase->id,
            localTeamId: $LocalTeam->id,
            awayTeamId: $AwayTeam->id,
            dateStartGame: (new \DateTime())->format('Y-m-d H:i:s'),
            externalApiIdEspn: $externalApiIdEspn
        );

        $Game = $this->CreateGameAction->__invoke($Command);

        $this->assertEquals($externalApiIdEspn, $Game->external_api_id_espn);
    }
}
