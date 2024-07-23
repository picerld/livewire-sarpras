<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IncomingItemDetail>
 */
class IncomingItemDetailFactory extends Factory
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
            'incoming_item_id' => $this->faker->numberBetween(1, 10),
            'qty' => $this->faker->numberBetween(1, 10)
        ];
    }
}
