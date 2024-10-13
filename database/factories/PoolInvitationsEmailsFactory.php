<?php

namespace Database\Factories;

use Betpool\Pool\Domain\Pool;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PoolInvitationsEmails>
 */
class PoolInvitationsEmailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'pool_id' => Pool::factory()->create(),
            'email' => $this->faker->unique()->safeEmail()
        ];
    }
}
