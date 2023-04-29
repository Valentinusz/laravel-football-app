<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $name = fake()->unique()->city();
        $hasPlaceHolder = (rand(0,3) === 3);
        return [
            'name' => $name,
            'shortname' => fake()->lexify(),
            'image' => $hasPlaceHolder ? null : fake()->imageUrl(48, 48)
        ];
    }
}
