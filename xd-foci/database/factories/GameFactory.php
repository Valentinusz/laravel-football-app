<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [];
    }

    /**
     * Factory state that produces games that have ended.
     * (Finished is true and start date is at least 90 minutes before current datetime.)
     *
     * @return Factory
     */
    public function finished(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'finished' => true,
                'start' => fake()->dateTimeBetween('-30 years', '-90 minutes')
            ];
        });
    }

    /**
     * Factory state that produces games that are currently in progress.
     * (Finished is false and start date is at most 120 minutes before current datetime.)
     *
     * @return Factory
     */
    public function onGoing(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'finished' => false,
                'start' => fake()->dateTimeBetween('-120 minutes')
            ];
        });
    }
}
