<?php

namespace App\Actions\Game\Query;

use App\Actions\Game\Query\Filters\CompetitionPhaseFilter;
use App\Models\Game;
use Illuminate\Pipeline\Pipeline;
use stdClass;

/**
 * Class GetGamesActionByCriteria
 */
class GetGamesActionByCriteria
{
    public function __invoke(
        GetGameByCriteriaQuery $GetGameByCriteriaQuery
    ) {
        $QueryBuilder = Game::query();

        $DtoPipeline = new stdClass;
        $DtoPipeline->QueryBuilder = $QueryBuilder;
        $DtoPipeline->GetGameByCriteriaQuery = $GetGameByCriteriaQuery;

        return app(Pipeline::class)
            ->send($DtoPipeline)
            ->through([
                CompetitionPhaseFilter::class,
            ])
            ->thenReturn()
            ->get();
    }
}
