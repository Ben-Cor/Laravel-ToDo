<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' =>fake()->words(5, true),
            'completed' => fake()->boolean(50),
            'user_id' =>fake()->numberBetween(1, 20),
            'due_date' =>fake()->dateTime(),
        ];
    }
}
