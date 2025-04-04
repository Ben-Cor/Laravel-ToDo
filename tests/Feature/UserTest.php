<?php

namespace Tests\Feature;

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
}
