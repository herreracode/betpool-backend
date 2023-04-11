<?php

namespace Tests\Unit\Competition\Actions;

use App\Actions\Competition\CreateCompetitionPhase;
use App\Models\Competition;
use App\Models\CompetitionPhase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Tests\TestCase;

class CreateCompetitionPhaseTest extends TestCase
{
    use RefreshDatabase;
    use WithoutEvents;

    protected function setUp(): void
    {
        parent::setup();

        $this->CreateCompetitionPhaseAction = app(CreateCompetitionPhase::class);
    }

    public function testCreateCompetition()
    {
        $Competition = Competition::factory()->create();

        $CompetitionPhaseTest = CompetitionPhase::factory()->make();

        $CompetitionPhaseCreate = $this->CreateCompetitionPhaseAction->__invoke($Competition, $CompetitionPhaseTest->name);

        $this->assertEquals($CompetitionPhaseTest->name, $CompetitionPhaseCreate->name);
    }
}
