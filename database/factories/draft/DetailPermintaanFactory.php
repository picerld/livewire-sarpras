<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetailPermintaan>
 */
class DetailPermintaanFactory extends Factory
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
            'permintaan_id' => $this->faker->numberBetween(1, 10),
            'kuantiti' => $this->faker->numberBetween(1, 10),
            'kuantiti_disetujui' => $this->faker->numberBetween(1, 10),
        ];
    }
}
