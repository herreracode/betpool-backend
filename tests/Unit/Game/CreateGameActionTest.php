<?php

namespace Tests\Unit\Game\Actions;

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

    public function testCreateCompetition()
    {
        $CompetitionPhase = CompetitionPhase::factory()
        ->for(Competition::factory())
        ->create();

        $LocalTeam = Team::factory()->create();

        $AwayTeam = Team::factory()->create();

        $Game = $this->CreateGameAction->__invoke(
            $CompetitionPhase,
            $LocalTeam,
            $AwayTeam
        );

        $this->assertEquals($Game->localTeam->id, $LocalTeam->id);

        $this->assertEquals($Game->awayTeam->id, $AwayTeam->id);

        $this->assertEquals($Game->awayTeam->id, $AwayTeam->id);

        $this->assertEquals($Game->competitionPhase->id, $CompetitionPhase->id);
    }
}
