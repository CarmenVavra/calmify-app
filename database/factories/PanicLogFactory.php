<?php

namespace Database\Factories;

use App\Models\PanicLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PanicLog>
 */
class PanicLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'triggered_at' => fake()->dateTimeBetween('-30 days'),
            'duration_minutes' => fake()->numberBetween(1, 10),
        ];
    }
}
