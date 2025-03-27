<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Category_Task_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 40; $i++) {
            DB::table('category_task')->insert([
                'category_id' => fake()->numberBetween(1, 15),
                'task_id' => fake()->numberBetween(1, 40),
            ]);
        }
    }
}
