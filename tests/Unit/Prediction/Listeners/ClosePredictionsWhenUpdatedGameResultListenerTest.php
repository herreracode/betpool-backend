<?php

namespace Prediction\Listeners;

use App\Events\UpdatedGameResult;
use App\Listeners\ClosePredictionsWhenUpdatedGameResultListener;
use App\Models\Competition;
use App\Models\CompetitionPhase;
use App\Models\Game;
use App\Models\Pool;
use App\Models\Prediction;
use App\Models\Score;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
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
            ->inFinish()
            ->for($CompetitionPhase)
            ->for(
                Team::factory()->create(), 'localTeam'
            )->for(
                Team::factory()->create(), 'awayTeam'
            )
            ->hasScore()
            ->create();

        Prediction::factory(50)
            ->inPending()
            ->for($Game)
            ->for(User::factory())
            ->for(Pool::factory())
            ->hasScore()
            ->create();

        $this
            ->EventUpdatedGameResult
            ->shouldReceive('getAggregate')
            ->once()
            ->andReturn($Game);

        $this->Listener->handle($this->EventUpdatedGameResult);

        $Predictions = Prediction::where([
            'game_id' => $Game->id
        ])->get();

        $hasPredictionNotClosed = $Predictions
            ->filter(fn (Prediction $prediction) => !$prediction->itIsInClose())
            ->count() > 0;

        $this->assertTrue(!$hasPredictionNotClosed);
    }

}
