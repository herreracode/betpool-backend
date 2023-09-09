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
    protected $signature = 'games:update-games-by-external-api {--date=}';

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

        $dates = $this->option('date') ? : $this->getDateToSearchGames();

        try {

            if(is_array($dates)){

                foreach ($dates as $date){

                    echo $date;
                    $Competitions
                        ->each(
                            $this->updateGameByCompetition($UpdateResultGamesForExternalApi, $date)
                        );

                }

            }else{

                echo $dates;
                $Competitions
                    ->each(
                        $this->updateGameByCompetition($UpdateResultGamesForExternalApi, $dates)
                    );
            }

        } catch(\Exception $e){
            var_dump("asdasdas");
            var_dump($e->getMessage());
        }

        return Command::SUCCESS;
    }

    protected function updateGameByCompetition($UpdateResultGamesForExternalApi, $date)
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

        foreach (range(0, static::NUMBER_DAYS_TO_UPDATE) as $numberDaysTo)
        {
            $dates[] = (new \DateTime())
                ->modify("-{$numberDaysTo} day")
                ->format('Ymd');
        }

        return $dates;
    }
}
