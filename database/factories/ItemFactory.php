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
            'id' => $this->faker->randomNumber(9),
            'name' => $this->faker->word(),
            'unit' => 'Pcs',
            'images' => 'img/subission.webp',
            'price' => $this->faker->numberBetween(2000, 5000),
            'merk' => $this->faker->word(),
            'color' => $this->faker->word(),
            'type' => $this->faker->word(),
            'size' => $this->faker->word(),
            'images' => $this->faker->imageUrl(640, 480, 'items', true),
            'stock' => $this->faker->numberBetween(10, 100),
            'minimum_stock' => $this->faker->numberBetween(10, 100),
            'category_id' => $this->faker->numberBetween(1, 5),
            'description' => $this->faker->paragraph(1)
        ];
    }
}
