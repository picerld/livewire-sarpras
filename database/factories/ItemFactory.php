<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'code' => 'item-' . $this->faker->numberBetween(1, 10),
            'merk' => $this->faker->word(),
            'unit' => 'unit',
            'price' => $this->faker->numberBetween(2000, 5000),
            'category_id' => $this->faker->numberBetween(1, 10),
            'stock' => $this->faker->numberBetween(10, 100),
            'minimum_stock' => $this->faker->numberBetween(10, 100),
            'description' => $this->faker->paragraph(1) 
        ];
    }
}
