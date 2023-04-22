<?php

namespace App\Console\Commands;

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

        $Competitions->each($this->createGameByCompetition());

        return Command::SUCCESS;
    }

    protected function createGameByCompetition()
    {
        return function (Competition $Competition){




        };
    }
}
