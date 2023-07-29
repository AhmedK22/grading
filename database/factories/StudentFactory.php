<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $project = Project::query()->inRandomOrder()->first();
        return [
            'name'=>$this->faker->name(),
            'email'=>$this->faker->unique()->email(),
            'password'=>Hash::make('12345678'),
            'program'=>$this->faker->randomElement(['cs','st & cs']),
            'final_mark'=>$this->faker->randomElement([130,100,120,110]),
            'level'=>$this->faker->randomElement(['first','second','third','forth']),
            'sitting_no'=>$this->faker->randomElement([337979,65565,565425,65462,4643,5624]),
            // 'project_id'=>$project->id,

        ];
    }
}
