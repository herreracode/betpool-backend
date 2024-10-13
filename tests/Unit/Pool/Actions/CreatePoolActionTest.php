<?php

namespace Tests\Unit\Pool\Actions;

use App\Actions\Pool\CreatePool;
use App\Events\CreatedPool;
use App\Exceptions\Pool\CompetitionMustBeUniqueInAPool;
use App\Models\Competition;
use App\Models\User;
use Betpool\Pool\Domain\Pool;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Illuminate\Support\Facades\Event;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CreatePoolActionTest extends TestCase
{
    use RefreshDatabase;
    use WithoutEvents;

    protected function setUp(): void
    {
        parent::setup();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        $this->CreatePoolAction = app(CreatePool::class);
    }

    /**
     *
     * @return void
     */
    public function testCreatePoolHappyPath()
    {
        Event::fake();

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

        $competitions = Competition::factory(2)->create();

        $namePool = "liverpool FC";

        $Pool = $this->CreatePoolAction->__invoke(
            $UserCreator,
            $namePool,
            $competitions
        );

        $PoolCreated = Pool::find($Pool->id);

        $this->assertInstanceOf(Pool::class, $PoolCreated);

        $this->assertSame($namePool, $PoolCreated->name);

        $this->assertSame($UserCreator->id, $Pool->users->first()->id);

        $this->assertSame(2, $Pool->competitions->count());

        $this->assertTrue($UserCreator->hasRolePoolAdmin($Pool));

        Event::assertDispatched(CreatedPool::class);
    }

    /**
     *
     * @return void
     */
    public function testCreatePoolWithoutCompetitionsIterable()
    {
        $UserCreator = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $UserCreator = Sanctum::actingAs(
            $UserCreator,
            ['*']
        );

        $namePool = "liverpool FC";

        $Pool = $this->CreatePoolAction->__invoke(
            $UserCreator,
            $namePool
        );

        $PoolCreated = Pool::find($Pool->id);

        $this->assertInstanceOf(Pool::class, $PoolCreated);
        $this->assertSame($namePool, $PoolCreated->name);
        $this->assertSame($UserCreator->id, $Pool->users->first()->id);

        setPermissionsTeamId($Pool->id);

        $RolePoolAdmin = Role::findByName('_POOL_ADMIN_');

        $this->assertTrue($UserCreator->hasRole($RolePoolAdmin));
    }

    /**
     * @return void
     */
    public function testThrowExceptionWhenCreatePoolWithVariousCompetitionIncludingSingleCompetition()
    {
        $this->expectException(CompetitionMustBeUniqueInAPool::class);

        $CompetitionUnique = Competition::factory()->mustBeUnique()->create();

        $competitions = Competition::factory(2)->create();

        $competitions = $competitions->push($CompetitionUnique);

        $namePool = "liverpool FC";

        $UserCreator = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $UserCreator = Sanctum::actingAs(
            $UserCreator,
            ['*']
        );

        $this->CreatePoolAction->__invoke(
            $UserCreator,
            $namePool,
            competitions: $competitions
        );
    }

    public function testCreatePoolWhenSendPossiblesEmailsUsersInvitates()
    {
        $safesEmails = [];
        $numberRandEmails = rand(1,6);

        foreach (range(1, $numberRandEmails) as $item)
            $safesEmails[] = fake()->safeEmail();

        $namePool = "liverpool FC";

        $UserCreator = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $UserCreator = Sanctum::actingAs(
            $UserCreator,
            ['*']
        );

        $Pool = $this->CreatePoolAction->__invoke(
            $UserCreator,
            $namePool,
            emailsPossiblesUsersPools: $safesEmails
        );

        $PoolsInvitationsEmails = $Pool->poolInvitationsEmails;

        $this->assertTrue($PoolsInvitationsEmails->count() == $numberRandEmails);
    }


}
