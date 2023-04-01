<?php

namespace App\Actions\Game;

use App\Events\Common\Contracts\EventBus;
use App\Models\Game;
use App\Models\Score;
use Exception;

/**
 * Class CreateGame
 */
class UpdateGameResult
{
    public function __construct(protected EventBus $eventBus)
    {
    }


    /**
     * @param Game $Game
     * @param int $localTeamScore
     * @param int $awayTeamScore
     * @return Score
     * @throws Exception
     */
    public function __invoke(
           Game $Game,
           int $localTeamScore,
           int $awayTeamScore,
    ): Score {

        $Score = $Game->updateGameResult($localTeamScore, $awayTeamScore);

        $this->eventBus->dispatch($Game->pullDomainEvents());

        return $Score;
    }
}
