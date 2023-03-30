<?php

namespace Database\Factories;

use App\Models\Enums\GameStatus;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'local_team_id' => Team::factory()->create(),
            'away_team_id' => Team::factory()->create(),
        ];
    }

    public function inProgress()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => GameStatus::IN_PROGRESS->value,
            ];
        });
    }

    public function inPending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => GameStatus::PENDING->value,
            ];
        });
    }
}
