<?php

namespace Database\Factories;

use App\Models\Enums\GameStatus;
use App\Models\Enums\PredictionStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prediction>
 */
class PredictionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
        ];
    }

    public function inPending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => PredictionStatus::PENDING->value,
            ];
        });
    }
}
