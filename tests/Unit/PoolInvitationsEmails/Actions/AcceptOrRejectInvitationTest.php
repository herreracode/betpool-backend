<?php

namespace Tests\Unit\PoolInvitationsEmails\Actions;

use App\Actions\Pool\CreatePool;
use App\Actions\PoolInvitationsEmails\AcceptOrRejectInvitation;
use App\Events\AcceptInvitationPool;
use App\Events\CreatedPool;
use App\Exceptions\Pool\CompetitionMustBeUniqueInAPool;
use App\Models\Competition;
use App\Models\Pool;
use App\Models\PoolInvitationsEmails;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Illuminate\Support\Facades\Event;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AcceptOrRejectInvitationTest extends TestCase
{
    use RefreshDatabase;
    use WithoutEvents;

    protected function setUp(): void
    {
        parent::setup();

        $this->AcceptOrRejectInvitation = app(AcceptOrRejectInvitation::class);
    }

    /**
     *
     * @return void
     */
    public function testAcceptInvitationHappyPath()
    {
        Event::fake();

        $PoolInvitationsEmails = PoolInvitationsEmails::factory()
        ->create()
        ->refresh();

        $User = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $PoolInvitationReturned = $this->AcceptOrRejectInvitation->__invoke($PoolInvitationsEmails, true, $User->id);

        $this->assertTrue($PoolInvitationReturned->accepted);
        $this->assertTrue($PoolInvitationReturned->user_id == $User->id);

        Event::assertDispatched(AcceptInvitationPool::class);
    }

    public function testRejectInvitationHappyPath()
    {
        $PoolInvitationsEmails = PoolInvitationsEmails::factory()
        ->create()
        ->refresh();

        $User = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $PoolInvitationReturned = $this->AcceptOrRejectInvitation->__invoke($PoolInvitationsEmails, false, $User->id);

        $this->assertNotTrue($PoolInvitationReturned->accepted);
        $this->assertTrue($PoolInvitationReturned->user_id == $User->id);
    }
}
