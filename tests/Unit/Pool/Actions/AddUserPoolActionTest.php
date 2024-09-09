<?php

namespace Tests\Unit\Pool\Actions;

use App\Actions\Pool\AddUserToPool;
use App\Actions\Pool\DeletePool;
use App\Exceptions\Pool\PoolHasPredictions;
use App\Models\Competition;
use App\Models\CompetitionPhase;
use App\Models\Game;
use App\Models\Pool;
use App\Models\PoolRound;
use App\Models\Prediction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AddUserPoolActionTest extends TestCase
{
    use RefreshDatabase;
    use WithoutEvents;

    protected function setUp(): void
    {
        parent::setup();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        $this->AddUserToPool = app(AddUserToPool::class);
    }

    public function testAddUserToPoolHappyPath()
    {
        $UserAdder = User::factory()->create();

        $UserAdder = Sanctum::actingAs(
            $UserAdder,
            ['*']
        );

        $Pool = Pool::factory()
            ->create();

        $status = $this->AddUserToPool->__invoke(
            $UserAdder,
            $Pool
        );

        $this->assertTrue($status);
    }

    public function testDeletePoolExpectExceptionPoolWithPredictionsCreated()
    {

    }

}
