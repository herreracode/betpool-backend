<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Competition>
 */
class CompetitionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->randomElements([
                'FIFA WORLD CUP',
                'AMERICAN CUP',
                'EUROPE CUP',
            ])[0],
            'must_be_unique' => false,
            'key_external_api' => 'eng.1',
        ];
    }

    public function mustBeUnique()
    {
        return $this->state(function (array $attributes) {
            return [
                'must_be_unique' => true,
            ];
        });
    }
}
