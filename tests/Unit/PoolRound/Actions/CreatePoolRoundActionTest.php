<?php

namespace Tests\Unit\PoolRound\Actions;

use App\Actions\Pool\CreatePool;
use App\Actions\PoolRound\CreatePoolRound;
use App\Events\CreatedPool;
use App\Exceptions\Pool\CompetitionMustBeUniqueInAPool;
use App\Exceptions\PoolRound\GameIsNotPending;
use App\Exceptions\PoolRound\UserDoesNotHaveTheRequiredRole;
use App\Models\Competition;
use App\Models\CompetitionPhase;
use App\Models\Game;
use App\Models\Pool;
use App\Models\PoolRound;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Illuminate\Support\Facades\Event;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CreatePoolRoundActionTest extends TestCase
{
    use RefreshDatabase;
    use WithoutEvents;

    protected function setUp(): void
    {
        parent::setup();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        $this->CreatePoolRoundAction = app(CreatePoolRound::class);
    }

    /**
     *
     * @return void
     */
    public function testCreatePoolRoundHappyPath()
    {

        /**
         * @var User $UserCreator
         */
        $UserCreator = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $UserCreator = Sanctum::actingAs(
            $UserCreator,
            ['*']
        );

        $Pool = Pool::factory()->create();

        $UserCreator->addRoleUserCreatorByPool($Pool);

        $Competition = Competition::factory();

        $CompetitionPhase = CompetitionPhase::factory()->for($Competition);

        $Games = Game::factory(3)
            ->for($CompetitionPhase)
            ->inPending()
            ->create();

        $PoolRound = $this->CreatePoolRoundAction->__invoke(
            $UserCreator,
            $Pool,
            $Games
        );

        $this->assertInstanceOf(PoolRound::class, $PoolRound);

        $this->assertEquals($PoolRound->games->pluck('id'), $Games->pluck('id'));
    }

    public function testThrowExceptionWhenGameIsNotPending()
    {
        $this->expectException(GameIsNotPending::class);

        /**
         * @var User $UserCreator
         */
        $UserCreator = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $UserCreator = Sanctum::actingAs(
            $UserCreator,
            ['*']
        );

        $Pool = Pool::factory()->create();

        $UserCreator->addRoleUserCreatorByPool($Pool);

        $Competition = Competition::factory();

        $CompetitionPhase = CompetitionPhase::factory()->for($Competition);

        $Games = Game::factory(3)
            ->for($CompetitionPhase)
            ->inProgress()
            ->create();

        $this->CreatePoolRoundAction->__invoke(
            $UserCreator,
            $Pool,
            $Games
        );
    }

    public function testThrowExceptionWhenUserDontHaveRolePoolAdmin()
    {
        $this->expectException(UserDoesNotHaveTheRequiredRole::class);

        /**
         * @var User $UserCreator
         */
        $UserCreator = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $UserCreator = Sanctum::actingAs(
            $UserCreator,
            ['*']
        );

        $UserCreator2 = User::factory()->create([
        'name' => 'Test User 2',
        'email' => 'tes2t@example.com',
        ]);

        $UserCreator2 = Sanctum::actingAs(
            $UserCreator2,
            ['*']
        );


        $Pool = Pool::factory()->create();

        //parche para que no de error que no existe el rol definido
        //luego cambiar
        $UserCreator2->addRoleUserCreatorByPool($Pool);

        $Competition = Competition::factory();

        $CompetitionPhase = CompetitionPhase::factory()->for($Competition);

        $Games = Game::factory(3)
            ->for($CompetitionPhase)
            ->inPending()
            ->create();

        $this->CreatePoolRoundAction->__invoke(
            $UserCreator,
            $Pool,
            $Games
        );

    }

}
