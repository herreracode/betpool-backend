<?php

namespace Database\Seeders;

use App\Models\Pool;
use Illuminate\Database\Seeder;

class PoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pool::factory(10)->create();
    }
}
