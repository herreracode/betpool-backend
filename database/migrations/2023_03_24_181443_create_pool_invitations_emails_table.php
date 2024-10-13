<?php

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
        Schema::create('pool_invitations_emails', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Betpool\Pool\Domain\Pool::class)->references('id')->on('pools');
            $table->bigInteger('user_id')->nullable();
            $table->string('email');
            $table->boolean('effective')->default(1);
            $table->boolean('accepted')->nullable();
            $table->timestamps();

            $table->unique([
                'email',
                'pool_id'
            ]);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pool_invitations_emails');
    }
};
