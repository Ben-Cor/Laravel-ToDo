<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{

    public function run(): void
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
            DB::table('categories')->insert([
                'name' => $category,
                'user_id' =>fake()->numberBetween(1, 20),
            ]);
        }

    }
}
