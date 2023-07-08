<?php

namespace Tests\Unit\Team\Actions;

use App\Actions\Team\FindOrCreateTeam;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Tests\TestCase;

class FindOrCreateTeamActionTest extends TestCase
{
    use RefreshDatabase;
    use WithoutEvents;

    protected function setUp(): void
    {
        parent::setup();

        $this->FindOrCreateAction = app(FindOrCreateTeam::class);
    }

    public function testCreateCompetition()
    {
        $TeamTest = Team::factory()->make();

        $TeamCreate = $this->FindOrCreateAction->__invoke($TeamTest->name, $TeamTest->abbreviation);

        $this->assertEquals($TeamTest->name, $TeamCreate->name);
        $this->assertEquals($TeamTest->abbreviation, $TeamCreate->abbreviation);
    }

    public function testFindCompetitionWhenIsAlreadyCreate()
    {
        $TeamTest = Team::factory()->create();

        $TeamFind = $this->FindOrCreateAction->__invoke($TeamTest->name, $TeamTest->abbreviation);

        $this->assertEquals($TeamTest->id, $TeamFind->id);
        $this->assertEquals($TeamTest->name, $TeamFind->name);
        $this->assertEquals($TeamTest->abbreviation, $TeamFind->abbreviation);
    }
}
