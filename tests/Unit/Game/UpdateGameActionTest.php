<?php

namespace Tests\Unit\Game\Actions;

use App\Actions\Game\UpdateGameResult;
use App\Events\GameUpdateResult;
use App\Models\Competition;
use App\Models\CompetitionPhase;
use App\Models\Game;
use App\Models\Score;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Illuminate\Support\Facades\Event;
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

    public function testUpdateGameResultHappyPath()
    {
        Event::fake();

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

        $this->assertTrue($Game->itIsFinished());

        Event::assertDispatched(GameUpdateResult::class);
    }
}
