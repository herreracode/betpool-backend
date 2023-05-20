<?php

namespace App\Console\Commands;

use App\Actions\Game\CreateGamesForExternalApi;
use App\Actions\Game\UpdateResultGamesForExternalApi;
use App\Models\Competition;
use Illuminate\Console\Command;

class UpdateGamesByExternalApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'games:update-games-by-external-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'hello';

    const NUMBER_DAYS_TO_UPDATE = 8;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $Competitions = Competition::all();

        $UpdateResultGamesForExternalApi = app(UpdateResultGamesForExternalApi::class);

        $dates = $this->getDateToSearchGames();

        try {

            if(is_array($dates)){

                foreach ($dates as $date)
                    $Competitions
                        ->each(
                            $this->createGameByCompetition($UpdateResultGamesForExternalApi, $date)
                        );
            }else{
                $Competitions
                    ->each(
                        $this->createGameByCompetition($UpdateResultGamesForExternalApi, $dates)
                    );
            }

        } catch(\Exception $e){
            //code for fail
        }

        return Command::SUCCESS;
    }

    protected function createGameByCompetition($UpdateResultGamesForExternalApi, $date)
    {
        return function (Competition $Competition) use($UpdateResultGamesForExternalApi, $date) {

            $UpdateResultGamesForExternalApi
                ->__invoke(
                    $Competition,
                    $date
                );
        };
    }

    protected function getDateToSearchGames() : array
    {
        $dates = [];

        foreach (range(1, static::NUMBER_DAYS_TO_UPDATE) as $numberDaysTo)
        {
            $dates[] = (new \DateTime())
                ->modify("-{$numberDaysTo} day")
                ->format('Ymd');
        }

        return $dates;
    }
}
