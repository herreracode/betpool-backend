<?php

namespace Tests\Unit\Pool\Actions;

use App\Actions\Pool\DeletePool;
use App\Models\Competition;
use App\Models\CompetitionPhase;
use App\Models\Game;
use App\Models\PoolRound;
use App\Models\Prediction;
use App\Models\User;
use Betpool\Pool\Domain\Exceptions\PoolHasPredictions;
use Betpool\Pool\Domain\Pool;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeletePoolActionTest extends TestCase
{
    use RefreshDatabase;
    use WithoutEvents;

    protected function setUp(): void
    {
        parent::setup();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        $this->DeletePoolAction = app(DeletePool::class);
    }

    public function testDeletePoolHappyPath()
    {
        $UserDeleter = User::factory()->create();

        $UserDeleter = Sanctum::actingAs(
            $UserDeleter,
            ['*']
        );

        $Pool = Pool::factory()
            ->hasAttached($UserDeleter)
            ->create();

        $UserDeleter->addRoleUserCreatorByPool($Pool);

        $status = $this->DeletePoolAction->__invoke(
            $UserDeleter,
            $Pool
        );

        $this->assertTrue($status);
    }

    public function testDeletePoolExpectExceptionPoolWithPredictionsCreated()
    {
        $this->expectException(PoolHasPredictions::class);

        $Competition = Competition::factory();

        $CompetitionPhase = CompetitionPhase::factory()->for($Competition);

        $UserDeleter = User::factory()->create();

        $UserDeleter = Sanctum::actingAs(
            $UserDeleter,
            ['*']
        );

        $Pool = Pool::factory()
            ->hasAttached($UserDeleter)
            ->create();

        $PoolRound = PoolRound::factory()
            ->for($Pool)
            ->create();

        $Game = Game::factory()
            ->inPending()
            ->for($CompetitionPhase)
            ->create();

        $UserDeleter->addRoleUserCreatorByPool($Pool);

        Prediction::factory()
            ->for($UserDeleter)
            ->for($Pool)
            ->for($PoolRound)
            ->for($Game)
            ->inPending()
            ->create();

        $status = $this->DeletePoolAction->__invoke(
            $UserDeleter,
            $Pool
        );

        $this->assertTrue($status);
    }

}
