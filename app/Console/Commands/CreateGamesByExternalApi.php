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

    const NUMBER_DAYS_TO_CREATE = 8;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $Competitions = Competition::all();

        $CreateGamesForExternalApi = app(CreateGamesForExternalApi::class);

        $dates = $this->getDateToSearchGames();

        try {

            if(is_array($dates)){

                foreach ($dates as $date)
                    $Competitions
                        ->each(
                            $this->createGameByCompetition($CreateGamesForExternalApi, $date)
                        );
            }else{
                $Competitions
                    ->each(
                        $this->createGameByCompetition($CreateGamesForExternalApi, $dates)
                    );
            }

        } catch(\Exception $e){
            //code for fail
        }

        return Command::SUCCESS;
    }

    protected function createGameByCompetition($CreateGamesForExternalApi, $date)
    {
        return function (Competition $Competition) use($CreateGamesForExternalApi, $date) {

            $CreateGamesForExternalApi
                ->__invoke(
                    $Competition,
                    $date
                );
        };
    }

    protected function getDateToSearchGames() : array
    {
        $dates = [];

        foreach (range(1, static::NUMBER_DAYS_TO_CREATE) as $numberDaysTo)
        {
            $dates[] = (new \DateTime())
                ->modify("+{$numberDaysTo} day")
                ->format('Ymd');
        }

        return $dates;
    }
}
