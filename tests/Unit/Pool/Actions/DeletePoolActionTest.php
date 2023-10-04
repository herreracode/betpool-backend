<?php

namespace Tests\Unit\Pool\Actions;

use App\Actions\Pool\DeletePool;
use App\Models\Pool;
use App\Models\User;
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


    }

}
