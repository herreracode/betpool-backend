<?php

namespace Tests\Unit\Prediction\Queries;

use App\Models\Competition;
use App\Models\CompetitionPhase;
use App\Models\Game;
use App\Models\Pool;
use App\Models\PoolRound;
use App\Models\Prediction;
use App\Models\User;
use App\Queries\Prediction\Filters\PoolFilter;
use App\Queries\Prediction\GetPredictionsByCriteria;
use App\Queries\Prediction\GetPredictionsByCriteriaQuery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Tests\TestCase;

class GetPredictionsByCriteriaTest extends TestCase
{
    use RefreshDatabase;
    use WithoutEvents;

    protected function setUp(): void
    {
        parent::setup();

        $this->GetPredictionsByCriteria = app(GetPredictionsByCriteria::class);
    }

    public function testGetPredictionsByCriteriaWhenSendPoolId()
    {
        $Competition = Competition::factory();

        $CompetitionPhase = CompetitionPhase::factory()->for($Competition);

        $Game = Game::factory()
            ->for($CompetitionPhase)
            ->create();

        $User = User::factory()->create();

        $Pool = Pool::factory()
            ->hasAttached($User)
            ->hasAttached($Competition)
            ->create();

        $Pool2 = Pool::factory()
            ->hasAttached($User)
            ->hasAttached($Competition)
            ->create();

        $PoolRound = PoolRound::factory()
            ->for($Pool)
            ->create();

        $PoolRound2 = PoolRound::factory()
            ->for($Pool2)
            ->create();

        $countPredictions = 5;

        $countPredictions2 = 7;

        Prediction::factory($countPredictions)
            ->for($User)
            ->for($Pool)
            ->for($PoolRound)
            ->for($Game)
            ->inPending()
            ->create();

        Prediction::factory($countPredictions2)
            ->for($User)
            ->for($Pool2)
            ->for($PoolRound2)
            ->for($Game)
            ->inPending()
            ->create();

        $PredictionsRecieved = $this->GetPredictionsByCriteria->__invoke(
            new GetPredictionsByCriteriaQuery(
                pool_id: $Pool->id,
            ),
            PoolFilter::class
        );

        $PredictionsRecieved2 = $this->GetPredictionsByCriteria->__invoke(
            new GetPredictionsByCriteriaQuery(
                pool_id: $Pool2->id,
            ),
            PoolFilter::class
        );

        $this->assertEquals($PredictionsRecieved->count(), $countPredictions);
        $this->assertEquals($PredictionsRecieved2->count(), $countPredictions2);
    }
}