<?php

namespace Tests\Unit\Game;

use App\Actions\Game\PostponeGame;
use App\Events\GamePostponed;
use App\Models\Competition;
use App\Models\CompetitionPhase;
use App\Models\Enums\GameStatus;
use App\Models\Game;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class PostponeGameActionTest extends TestCase
{
    use RefreshDatabase;
    use WithoutEvents;

    protected function setUp(): void
    {
        parent::setup();

        $this->PostponeGameAction = app(PostponeGame::class);
    }

    public function testPostponeGameHappyPath()
    {
        Event::fake();

        $CompetitionPhase = CompetitionPhase::factory()
        ->for(Competition::factory())
        ->create();

        $Game = Game::factory()
            ->inPending()
            ->for($CompetitionPhase)
            ->for(
                Team::factory()->create(), 'localTeam'
            )
            ->for(
                Team::factory()->create(), 'awayTeam'
            )
            ->create();

        /**
         * @var Game $GamePostponed
         */
        $GamePostponed = $this->PostponeGameAction->__invoke($Game);

        $this->assertTrue($GamePostponed->status == GameStatus::POSTPONED->value);

        Event::assertDispatched(GamePostponed::class);
    }
}
