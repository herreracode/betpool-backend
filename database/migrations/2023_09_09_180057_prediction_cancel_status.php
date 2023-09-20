<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE predictions MODIFY COLUMN status ENUM('_PENDING_', '_CLOSE_', '_CANCEL_') DEFAULT '_PENDING_' NOT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE predictions MODIFY COLUMN status ENUM('_PENDING_', '_CLOSE_') DEFAULT '_PENDING_' NOT NULL");
    }
};
