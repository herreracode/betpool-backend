<?php

namespace Tests\Unit\Competition\Actions;

use App\Actions\Competition\CreateCompetition;
use App\Models\Competition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Tests\TestCase;

class CreateCompetitionTest extends TestCase
{
    use RefreshDatabase;
    use WithoutEvents;

    protected function setUp(): void
    {
        parent::setup();

        $this->CreateCompetitionAction = app(CreateCompetition::class);
    }
    
    public function testCreateCompetition()
    {
        $CompetitionTest = Competition::factory()->make();

        $CompetitionCreate = $this->CreateCompetitionAction->__invoke($CompetitionTest->name);

        $this->assertEquals($CompetitionTest->name, $CompetitionCreate->name);
    }
}
