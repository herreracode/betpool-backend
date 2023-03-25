<?php

use App\Models\CompetitionPhase;
use App\Models\Game;
use App\Models\Pool;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Enums\GameStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('local_team_id')->references('id')->on('teams');
            $table->foreignId('away_team_id')->references('id')->on('teams');
            $table->foreignIdFor(CompetitionPhase::class);
            $table->enum('status',[
                GameStatus::PENDING->value,
                GameStatus::IN_PROGRESS->value,
                GameStatus::FINISH->value,
                GameStatus::POSTPONED->value,
            ])->default(GameStatus::PENDING->value);
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->timestamps();
        });

        Schema::create('predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->references('id')->on('users');
            $table->foreignIdFor(Pool::class)->references('id')->on('pools');
            $table->foreignIdFor(Game::class)->references('id')->on('games');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
};
