<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
                $json->hasAll('message', 'data');
            });
    }
}
