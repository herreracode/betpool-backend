<?php

use App\Models\Competition;
use App\Models\Pool;
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
        Schema::create('pools_competitions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Pool::class)->references('id')->on('pools');
            $table->foreignIdFor(Competition::class)->references('id')->on('competitions');
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
        Schema::dropIfExists('pools_competitions');
    }
};
