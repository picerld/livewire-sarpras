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
            'nama' => $this->faker->word(),
            'kode' => 'item-' . $this->faker->numberBetween(1, 10),
            'merek' => $this->faker->word(),
            'unit' => 'unit',
            'harga' => $this->faker->numberBetween(2000, 5000),
            'kategori_id' => $this->faker->numberBetween(1, 10),
            'stok' => $this->faker->numberBetween(10, 100),
            'stok_minimum' => $this->faker->numberBetween(10, 100),
        ];
    }
}
