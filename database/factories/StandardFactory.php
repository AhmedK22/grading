<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Standard>
 */
class StandardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['admin','progress','Demo','comminication','progress','contribution','TeamWork','presintation','technical']),
            'standardType' => $this->faker->randomElement(['examiner','supervisor']),
            'maxMark' => $this->faker->randomElement(['20','50']),

        ];
    }
}
