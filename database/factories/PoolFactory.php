<?php

namespace Database\Factories;

use Betpool\Pool\Domain\Pool;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Betpool\Pool\Domain\Pool>
 */
class PoolFactory extends Factory
{
    protected $model = Pool::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => "Pool {$this->faker->randomDigitNotNull()}",
        ];
    }
}
