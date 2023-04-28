<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $getTypeIndex = function() {
            $number = rand(0,9);

            // 30% chance for goal
            if ($number <= 2) {
                return 0;
            }

            // 20% chance for own goal
            if ($number <= 4) {
                return 1;
            }

            // 30% chance for yellow card
            if ($number <= 7) {
                return 2;
            }

            return 3;
        };

        $enumValues = ['gól', 'öngól', 'sárga lap', 'piros lap'];

        return [
            'minute' => rand(0, 120),
            'type' => $enumValues[$getTypeIndex()]
        ];
    }


    /**
     * Factory state that generates events for games that are currently in progress.
     * (Minute of the event will be between the start of the game and now.)
     *
     * @param int $gameLength current length of the game to generate events for.
     * @return Factory
     */
    public function inProgressGameEvent(int $gameLength): Factory {
        return $this->state(function () use (&$gameLength) {
            return [
                'minute' => rand(0, $gameLength)
            ];
        });
    }
}
