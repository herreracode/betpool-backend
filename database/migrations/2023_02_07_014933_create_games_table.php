<?php

use App\Models\CompetitionPhase;
use App\Models\Game;
use App\Models\Pool;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Enums\GameStatus;
use App\Models\Enums\PredictionStatus;

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
            $table->dateTime('date_start');
            $table->dateTime('date_end')->nullable();
            $table->bigInteger('external_api_id_espn')->nullable();
            $table->timestamps();
        });

        Schema::create('predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->references('id')->on('users');
            $table->foreignIdFor(Pool::class)->references('id')->on('pools');
            $table->foreignIdFor(Game::class)->references('id')->on('games');
            $table->enum('status',[
                PredictionStatus::PENDING->value,
                PredictionStatus::CLOSE->value,
            ])->default(PredictionStatus::PENDING->value);
            $table->integer('points_earned')->nullable();
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
