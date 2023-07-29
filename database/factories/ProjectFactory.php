<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
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
            'objective'=>$this->faker->text(),
            'description'=>$this->faker->text(),
            'num_of_students'=>$this->faker->randomDigit(),
            'max_mark'=>$this->faker->randomElement([150,200]),
            'skills'=>["skill1"=>"php"],
            // 'supervisor'=>["doc1"=>"d0cname"],

            'status'=>$this->faker->randomElement(['approved','pending']),
            'lastStatus'=>$this->faker->randomElement(['approved','pending']),
            'project_type' => $this->faker->randomElement(['search','creation']),
            'background'=>$this->faker->text(),
            'type'=>$this->faker->randomElement(['single','double']),

        ];
    }
}
