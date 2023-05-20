<?php

namespace App\Console\Commands;

use App\Actions\Game\CreateGamesForExternalApi;
use App\Models\Competition;
use Illuminate\Console\Command;

class CreateGamesByExternalApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'games:create-games-by-external-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'hello';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $Competitions = Competition::all();

        $CreateGamesForExternalApi = app(CreateGamesForExternalApi::class);

        $Competitions
            ->each(
                $this->createGameByCompetition($CreateGamesForExternalApi)
            );

        return Command::SUCCESS;
    }

    protected function createGameByCompetition($CreateGamesForExternalApi)
    {
        return function (Competition $Competition) use($CreateGamesForExternalApi) {

            $CreateGamesForExternalApi
                ->__invoke(
                    $Competition,
                    $this->getDateToSearchGames()
                );
        };
    }

    protected function getDateToSearchGames()
    {
        return '20230520';
    }
}
