<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Personal',
            'Work',
            'School',
            'Health',
            'Finance',
            'Home',
            'Family',
            'Friends',
            'Social',
            'Hobbies',
            'Travel',
            'Shopping',
            'Food',
            'Fitness',
            'Other',
        ];

        foreach ($categories as $category) {
            return [
                'name' => $category,
            ];
        }
    }
}
