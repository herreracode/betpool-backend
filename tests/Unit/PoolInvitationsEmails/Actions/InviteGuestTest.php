<?php

namespace Tests\Unit\PoolInvitationsEmails\Actions;

use App\Models\PoolInvitationsEmails;
use Betpool\Pool\Features\InviteGuest\DTO\RequestInviteGuest;
use Betpool\Pool\Features\InviteGuest\DTO\ResponseInviteGuest;
use Betpool\Pool\Features\InviteGuest\InviteGuest;
use Betpool\Pool\Domain\Pool;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Tests\TestCase;

class InviteGuestTest extends TestCase
{
    use RefreshDatabase;
    use WithoutEvents;

    protected function setUp(): void
    {
        parent::setup();

        $this->InviteGuest = app(InviteGuest::class);
    }

    public function testInviteGuestHappyPath()
    {
        $safesEmails = [];
        $numberRandEmails = rand(1,6);

        $Pool = Pool::factory()
            ->create();

        foreach (range(1, $numberRandEmails) as $item)
            $safesEmails[] = fake()->safeEmail();

        $RequestDto = new RequestInviteGuest(
            $safesEmails,
            $Pool->id
        );

        $response = $this->InviteGuest->__invoke($RequestDto);

        $this->assertInstanceOf(ResponseInviteGuest::class, $response);
    }

    public function testGivenGuestAlreadyHasInvitationWhenTheAdminAddGuestThenThrowExceptionInvitationExist()
    {
        $safesEmails = [];

        $Pool = Pool::factory()
            ->create();

        $email = fake()->safeEmail();

        PoolInvitationsEmails::factory()->create([
            'pool_id' => $Pool->id,
            'email' => $email
        ]);

        $safesEmails[] = $email;

        $RequestDto = new RequestInviteGuest(
            $safesEmails,
            $Pool->id
        );

        $response = $this->InviteGuest->__invoke($RequestDto);

        $this->assertInstanceOf(ResponseInviteGuest::class, $response);

        $result = array_filter($response->summary, fn($item) => $item['message'] == "USER_ALREADY_INVITED_POOL");

        $this->assertNotEmpty($result);
    }
}
