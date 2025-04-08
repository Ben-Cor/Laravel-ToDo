<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_users_controller_all()
    {
        User::factory()->count(3)->create();
        $response = $this->get('/api/users');
        $response->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll('message', 'data')
                    ->has('data', 3, function (AssertableJson $data) {
                        $data->hasAll([
                            'id',
                            'name',
                            'email',
                            'email_verified_at',
                            'experience',
                            'tasks',
                        ]);
                    });
            });
    }

    public function test_users_controller_find_user_not_found()
    {
        $response = $this->get('/api/users/1');
        $response->assertStatus(404)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll('message')
                    ->has('message')
                    ->where('message', 'User not found');
            });
    }

    public function test_users_controller_find_user()
    {
        $user = User::factory()->create();
        $response = $this->get('/api/users/'.$user->id);
        $response->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll('message', 'data')
                    ->has('data', function (AssertableJson $data) {
                        $data->hasAll([
                            'id',
                            'name',
                            'email',
                            'email_verified_at',
                            'experience',
                            'tasks',
                        ]);
                    });
            });
    }

    public function test_users_controller_add_user_success()
    {
        $request = [
            'name' => 'Test User',
            'email' => 'user@email.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        $response = $this->postJson('/api/users', $request);
        $response->assertStatus(201)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll('message', 'data')
                    ->has('data', function (AssertableJson $data) {
                        $data->hasAll([
                            'id',
                            'name',
                            'email',
                            'email_verified_at',
                            'experience',
                        ]);
                    });
            });

        $user = User::where('email', 'user@email.com')->first();
        $this->assertNotNull($user);
        $this->assertTrue(Hash::check('password', $user->password));
        $this->assertEquals(0, $user->experience);
    }

    public function test_users_controller_add_user_validation_fail()
    {
        $request = [
            'name' => 3,
            'email' => 'user',
            'password' => 's',
            'password_confirmation' => 'd',
        ];
        $response = $this->postJson('/api/users', $request);
        $response->assertStatus(422);
        $this->assertDatabaseEmpty('users');
    }

    public function test_users_controller_add_user_password_fail()
    {
        $request = [
            'name' => 'Test User',
            'email' => 'user@email.com',
            'password' => 'password',
            'password_confirmation' => 'passwordtest',
        ];
        $response = $this->postJson('/api/users', $request);
        $response->assertStatus(422);
        $this->assertDatabaseEmpty('users');
    }

    public function test_users_controller_delete_user_success()
    {
        $user = User::factory()->create();
        Task::factory()->create(['user_id' => $user->id]);
        $response = $this->delete('/api/users/'.$user->id);
        $response->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll('message')
                    ->where('message', 'User successfully deleted');
            });

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
        $this->assertDatabaseEmpty('tasks');
    }

    public function test_users_controller_delete_user_fail()
    {

        $response = $this->delete('/api/users/1');
        $response->assertStatus(404)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll('message')
                    ->where('message', 'User not found');
            });
    }
}
