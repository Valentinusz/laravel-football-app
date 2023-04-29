<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory {
    /**
     * Define the model's default state. By default, produces games that have ended.
     * (Finished is true and start date is at least 90 minutes before current datetime.)
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'finished' => true,
            'start' => fake()->dateTimeBetween('-4 months', '-90 minutes')
        ];
    }

    /**
     * Factory state that produces games that are currently in progress.
     * (Finished is false and start date is at most 120 minutes before current datetime.)
     *
     * @return Factory
     */
    public function onGoing(): Factory {
        return $this->state(function () {
            return [
                'finished' => false,
                'start' => fake()->dateTimeBetween('-90 minutes')
            ];
        });
    }

    /**
     * Factory state that produces games that will take place in the future.
     * (Finished is false and start date is after now.)
     *
     * @return Factory
     */
    public function future(): Factory {
        return $this->state(function () {
            return [
                'finished' => false,
                'start' => fake()->dateTimeBetween('now', '1 month')
            ];
        });
    }
}
