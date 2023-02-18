<?php

namespace Tests\Unit\Game\Actions;

use App\Actions\Game\CreateGame;
use App\Actions\Game\UpdateGameResult;
use App\Actions\Team\CreateTeam;
use App\Models\Competition;
use App\Models\CompetitionPhase;
use App\Models\Game;
use App\Models\Score;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Tests\TestCase;

class UpdateGameActionTest extends TestCase
{
    use RefreshDatabase;
    use WithoutEvents;

    protected function setUp(): void
    {
        parent::setup();

        $this->UpdateGameResultAction = app(UpdateGameResult::class);
    }

    public function testCreateCompetition()
    {
        $CompetitionPhase = CompetitionPhase::factory()
        ->for(Competition::factory())
        ->create();

        $Game = Game::factory()
            ->for($CompetitionPhase)
            ->for(
                Team::factory()->create(), 'localTeam'
            )->for(
                Team::factory()->create(), 'awayTeam'
            )
            ->create();

        $localTeamScore = 2;
        $awayTeamScore = 3;

        /**
         * @var Score $Score
         */
        $Score = $this->UpdateGameResultAction->__invoke(
            $Game,
            localTeamScore : $localTeamScore,
            awayTeamScore : $awayTeamScore
        );

        $this->assertEquals($Score->getLocalTeamScore(), $localTeamScore);

        $this->assertEquals($Score->getAwayTeamScore(), $awayTeamScore);
    }
}
