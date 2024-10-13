<?php

namespace Tests\Unit\Pool\Actions;

use App\Actions\Pool\AddUserToPool;
use App\Actions\Pool\DTO\RequestAddUserPool;
use App\Exceptions\Pool\UserAlreadyAdded;
use App\Models\User;
use Betpool\Pool\Domain\Pool;
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

    public function testGivenNeedAddUserWhenTheUserDoesNotBelongToPoolThenAddUserToPool()
    {
        $UserAdder = User::factory()->create();

        $UserAdder = Sanctum::actingAs(
            $UserAdder,
            ['*']
        );

        $Pool = Pool::factory()
            ->create();

        $RequestDto = new RequestAddUserPool(
            $Pool->id,
            [$UserAdder->email]
        );

        $status = $this->AddUserToPool->__invoke($RequestDto);

        $this->assertTrue($status);
    }

    public function testGivenNeedAddUserWhenUserIsAlreadyAddedToPoolThenThrowUserAlreadyAddedException()
    {
        $this->expectException(UserAlreadyAdded::class);

        $UserAdder = User::factory()->create();

        $UserAdder = Sanctum::actingAs(
            $UserAdder,
            ['*']
        );

        $Pool = Pool::factory()
            ->hasAttached($UserAdder)
            ->create();

        $RequestDto = new RequestAddUserPool(
            $Pool->id,
            [$UserAdder->email]
        );

        $this->AddUserToPool->__invoke($RequestDto);
    }

}
