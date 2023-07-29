<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'name'=>$this->faker->name(),
           'email'=>$this->faker->unique()->email(),
           'password'=>Hash::make('12345678'),
           'status'=>$this->faker->randomElement(['active','inActive']),
           'is_admin'=>$this->faker->randomElement([1,0]),

        ];
    }
}
