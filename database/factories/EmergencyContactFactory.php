<?php

namespace Database\Factories;

use App\Models\EmergencyContact;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EmergencyContact>
 */
class EmergencyContactFactory extends Factory
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
            'name' => fake()->firstName(),
            'relation' => fake()->randomElement(['Schwester', 'Freund', 'Therapeutin', 'Nachbarin']),
            'phone_number' => '+49 170 '.fake()->numerify('#######'),
        ];
    }
}
