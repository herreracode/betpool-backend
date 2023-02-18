<?php

namespace Tests\Unit\Game\Actions;

use App\Actions\Game\GetGameByCriteriaQuery;
use App\Actions\Game\GetGamesActionByCriteria;
use App\Models\Competition;
use App\Models\CompetitionPhase;
use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Tests\TestCase;

class GetGamesActionByCriteriaTest extends TestCase
{
    use RefreshDatabase;
    use WithoutEvents;

    protected function setUp(): void
    {
        parent::setup();

        $this->GetGamesActionByCriteriaAction = app(GetGamesActionByCriteria::class);
    }

    public function testGetGameActionByCriteriaWhenSendCompetitionPhase()
    {
        $Competition = Competition::factory();

        $CompetitionPhase = CompetitionPhase::factory()
        ->for($Competition)
        ->create();

        $CompetitionPhase2 = CompetitionPhase::factory()
        ->for($Competition)
        ->create();

        $countGameForCompetitionPhase = 5;

        $countGameForCompetitionPhase2 = 7;

        Game::factory($countGameForCompetitionPhase)->for($CompetitionPhase)->create();

        Game::factory($countGameForCompetitionPhase2)->for($CompetitionPhase2)->create();

        $Games1 = $this->GetGamesActionByCriteriaAction->__invoke(
            new GetGameByCriteriaQuery(
                competitionPhaseId:  $CompetitionPhase->id
            )
        );

        $Games2 = $this->GetGamesActionByCriteriaAction->__invoke(
            new GetGameByCriteriaQuery(
                competitionPhaseId:  $CompetitionPhase2->id
            )
        );

        $this->assertEquals($Games1->count(), $countGameForCompetitionPhase);

        $this->assertEquals($Games2->count(), $countGameForCompetitionPhase2);
    }
}
