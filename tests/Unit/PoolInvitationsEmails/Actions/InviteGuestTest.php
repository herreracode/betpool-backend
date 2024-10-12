<?php

namespace Tests\Unit\PoolInvitationsEmails\Actions;

use App\Actions\PoolInvitationsEmails\DTO\RequestInviteGuest;
use App\Actions\PoolInvitationsEmails\DTO\ResponseInviteGuest;
use App\Actions\PoolInvitationsEmails\InviteGuest;
use App\Models\Pool;
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
}
