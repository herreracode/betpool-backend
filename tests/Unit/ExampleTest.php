<?php

namespace Tests\Unit;

use App\Models\Pool;
use Database\Seeders\PoolSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_true_is_true()
    {
        $this->assertTrue(true);
    }

    public function test_models()
    {
        $this->seed(PoolSeeder::class);

        $hola = Pool::all();

        var_dump($hola->first());
    }
}
