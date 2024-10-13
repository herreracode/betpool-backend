<?php

use App\Models\Enums\PoolRoundStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pool_rounds', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Betpool\Pool\Domain\Pool::class)->references('id')->on('pools');
            $table->enum('status',[
                PoolRoundStatus::PENDING->value,
                PoolRoundStatus::FINISH->value,
            ])->default(PoolRoundStatus::PENDING->value);
            $table->date('date_finish')->nullable();
            $table->timestamps();
        });

        Schema::table('predictions', function (Blueprint $table){

            $table
                ->foreignIdFor(\App\Models\PoolRound::class)
                ->references('id')
                ->on('pool_rounds');

        });

        Schema::create('pool_round_games', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Game::class)->references('id')->on('games');
            $table->foreignIdFor(\App\Models\PoolRound::class)->references('id')->on('pool_rounds');
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
        Schema::table('predictions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('pool_round_id');
        });

        Schema::table('pool_round_games', function (Blueprint $table) {
            $table->dropConstrainedForeignId('pool_round_id');
        });

        Schema::dropIfExists('pool_round_games');

        Schema::dropIfExists('pool_rounds');
    }
};
