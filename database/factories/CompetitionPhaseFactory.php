<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompetitionPhase>
 */
class CompetitionPhaseFactory extends Factory
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
                'OCTAVOS',
                'CUARTOS',
                'SEMIFINAL',
                'FINAL',
            ])[0],
        ];
    }
}
