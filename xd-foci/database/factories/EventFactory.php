<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
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

        return [
            'type' => ['gól', 'öngól', 'sárga lap', 'piros lap'][$getTypeIndex()],
            'minute' => rand(0,120)
        ];
    }
}
