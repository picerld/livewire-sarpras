<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Submission>
 */
class SubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->unique()->randomNumber(9),
            'nip' => $this->faker->unique()->randomNumber(9),
            'status' => $this->faker->randomElement(['pending', 'accepted', 'rejected']),
            'regarding' => $this->faker->sentence(3),
            'total_items' => $this->faker->numberBetween(10, 100),
        ];
    }
}
