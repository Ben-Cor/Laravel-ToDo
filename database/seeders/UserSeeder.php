<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            DB::table('users')->insert([
                'name' => fake()->name,
                'email' => fake()->unique()->safeEmail,
                'password' => fake()->password,
                'experience' => fake()->numberBetween(1, 100),
            ]);
        }
    }
}
