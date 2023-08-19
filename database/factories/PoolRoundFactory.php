<?php

namespace Database\Factories;

use App\Models\PoolRound;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Enums\PoolRoundStatus;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pool>
 */
class PoolRoundFactory extends Factory
{
    protected $model = PoolRound::class;

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
                'status' => PoolRoundStatus::PENDING->value,
            ];
        });
    }
}
