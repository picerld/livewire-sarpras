<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RequestDetail>
 */
class RequestDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_id' => $this->faker->numberBetween(1, 10),
            'request_id' => $this->faker->numberBetween(1, 10),
            'qty' => $this->faker->numberBetween(1, 10),
            'qty_accepted' => $this->faker->numberBetween(1, 10),
        ];
    }
}
