<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit>
 */
class EmployeeFactory extends Factory
{
        /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $images = [
            "avatars/01.png",
            "avatars/02.png",
            "avatars/03.png",
            "avatars/04.png",
            "avatars/05.png"
        ];

        return [
            'nip' => fake()->unique()->randomNumber(5),
            'email' => fake()->unique()->safeEmail(),
            'avatar' => fake()->randomElement($images),
            'name' => fake()->name() ,
        ];
    }
}
