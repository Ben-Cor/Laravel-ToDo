<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 40; $i++) {
            DB::table('tasks')->insert([
                'content' => fake()->words(5, true),
                'completed' => fake()->boolean(50),
                'user_id' => fake()->numberBetween(1, 20),
                'due_date' => fake()->dateTime(),
            ]);
        }
    }
}
