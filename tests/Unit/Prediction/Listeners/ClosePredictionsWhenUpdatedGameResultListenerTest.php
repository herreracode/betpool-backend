<?php

namespace Prediction\Listeners;

use App\Events\UpdatedGameResult;
use App\Listeners\ClosePredictionsWhenUpdatedGameResultListener;
use App\Models\Competition;
use App\Models\CompetitionPhase;
use App\Models\Game;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Tests\TestCase;

class ClosePredictionsWhenUpdatedGameResultListenerTest extends TestCase
{
    use RefreshDatabase;

    use WithoutEvents;

    protected function setUp(): void
    {
        parent::setUp();

        $this->Listener = app(ClosePredictionsWhenUpdatedGameResultListener::class);
        $this->EventUpdatedGameResult = $this->mock(UpdatedGameResult::class);
    }

    public function testNormal()
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

        $this
            ->EventUpdatedGameResult
            ->shouldReceive('getAggregate')
            ->once()
            ->andReturn($Game);

        $this->Listener->handle($this->EventUpdatedGameResult);

        $this->assertTrue(true);
    }

}
