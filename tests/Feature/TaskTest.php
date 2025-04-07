<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Task;
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

    public function test_add_task_correct_with_category(): void
    {
        User::factory()->create(['id' => 1]);
        Category::factory()->create();

        $request = [
            'content' => 'Test task',
            'completed' => false,
            'user_id' => 1,
            'due_date' => null,
            'category_id' => 1,
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

        $this->assertDatabaseHas('category_task', [
            'task_id' => 1,
            'category_id' => 1,
        ]);

        $this->assertDatabaseCount('tasks', 1);
    }

    public function test_add_task_invalid(): void
    {
        User::factory()->create(['id' => 1]);

        $request = [
            'content' => 2,
            'completed' => 'apple',
            'user_id' => 5,
            'due_date' => 'date',
        ];

        $response = $this->postJson('/api/tasks', $request);

        $response->assertStatus(422);

        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_update_task_complete(): void
    {
        User::factory()->create(['id' => 1]);
        Task::factory()->create([
            'id' => 1,
            'content' => 'Test task',
            'user_id' => 1,
        ]);

        $request = [
            'content' => 'Test task updated name',
            'user_id' => 1,
        ];

        $response = $this->putJson('/api/tasks/1', $request);
        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', [
            'content' => 'Test task updated name',
            'completed' => false,
            'user_id' => 1,
            'due_date' => null,
        ]);
    }

    public function test_update_task_complete_with_category(): void
    {
        User::factory()->create(['id' => 1]);
        Category::factory()->count(3)->create();
        $task = Task::factory()->create([
            'id' => 1,
            'content' => 'Test task',
            'user_id' => 1,
            'completed' => false,
            'due_date' => null,
        ]);
        $task->categories()->attach(1);
        $task->save();

        $this->assertDatabaseHas('category_task', [
            'task_id' => 1,
            'category_id' => 1,
        ]);

        $request = [
            'content' => 'Test task updated name',
            'user_id' => 1,
            'category_id' => [2, 3],
        ];

        $response = $this->putJson('/api/tasks/1', $request);
        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', [
            'content' => 'Test task updated name',
            'completed' => false,
            'user_id' => 1,
            'due_date' => null,
        ]);
        $this->assertDatabaseMissing('category_task', [
            'task_id' => 1,
            'category_id' => 1,
        ]);
        $this->assertDatabaseHas('category_task', [
            'task_id' => 1,
            'category_id' => 2,
        ]);
        $this->assertDatabaseHas('category_task', [
            'task_id' => 1,
            'category_id' => 3,
        ]);
        $this->assertDatabaseCount('category_task', 2);
    }

    public function test_update_task_invalid(): void
    {
        User::factory()->create(['id' => 1]);
        Task::factory()->create([
            'id' => 1,
            'content' => 'Test task',
            'completed' => false,
            'due_date' => null,
            'user_id' => 1,
        ]);

        $request = [
            'content' => false,
            'user_id' => 1,
        ];

        $response = $this->putJson('/api/tasks/1', $request);
        $response->assertStatus(422);
        $this->assertDatabaseHas('tasks', [
            'content' => 'Test task',
            'completed' => false,
            'user_id' => 1,
            'due_date' => null,
        ]);
    }

    public function test_delete_task_success(): void
    {
        User::factory()->create(['id' => 1]);
        Task::factory()->create([
            'id' => 1,
            'content' => 'Test task',
            'completed' => false,
            'due_date' => null,
            'user_id' => 1,
        ]);

        $response = $this->deleteJson('/api/tasks/1');
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Task successfully deleted',
        ]);
        $this->assertDatabaseEmpty('tasks');
    }

    public function test_delete_task_fail(): void
    {
        $response = $this->deleteJson('/api/tasks/1');
        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Task not found',
        ]);
    }
}
