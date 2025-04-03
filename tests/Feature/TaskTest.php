<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_add_task_correct(): void
    {
        User::factory()->create(['id' => 1]);

        $request = [
            'content' => 'Test task',
            'completed' => false,
            'user_id' => 1,
            'due_date' => null,
        ];

        $response = $this->postJson('/api/tasks', $request);

        $response->assertStatus(201);
        $response->assertJson([
            'message' => 'Task successfully created',
        ]);

        $this->assertDatabaseHas('tasks', [
            'content' => 'Test task',
            'completed' => false,
            'user_id' => 1,
            'due_date' => null,
        ]);

        $this->assertDatabaseCount('tasks', 1);
    }
}
