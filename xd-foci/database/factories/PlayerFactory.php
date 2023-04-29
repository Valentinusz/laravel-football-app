<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'name' => fake()->name(),
            'number' => rand(0,99),
            'birthdate' => fake()->dateTimeBetween('-30 years', '-18 years')->format('Y-m-d'),
        ];
    }
}
