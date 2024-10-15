<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubmissionDetail>
 */
class SubmissionDetailFactory extends Factory
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
            'submission_code' => $this->faker->numberBetween(1, 10),
            'item_code' => $this->faker->numberBetween(1, 10),
            'qty' => $this->faker->numberBetween(1, 10),
            'custom_item' => null,
            'qty' => null,
            'qty_accepted' => $this->faker->numberBetween(1, 10),
            'accepted_by' => $this->faker->numberBetween(1, 10),
            'status_note' => null,
        ];
    }
}
