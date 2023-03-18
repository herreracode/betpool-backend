<?php

namespace Tests\Unit\Team\Actions;

use App\Actions\Team\CreateTeam;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Tests\TestCase;

class CreateTeamActionTest extends TestCase
{
    use RefreshDatabase;
    use WithoutEvents;

    protected function setUp(): void
    {
        parent::setup();

        $this->CreateTeamAction = app(CreateTeam::class);
    }

    public function testCreateCompetition()
    {
        $TeamTest = Team::factory()->make();

        $TeamCreate = $this->CreateTeamAction->__invoke($TeamTest->name);

        $this->assertEquals($TeamTest->name, $TeamCreate->name);
    }
}
