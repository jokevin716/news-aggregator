<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['data', 'access_token', 'token_type']);
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['message', 'access_token', 'token_type']);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        // Setup: Create a user
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('correct_password'),
        ]);

        // Action: Attempt to log in with invalid credentials
        $response = $this->postJson('/api/login', [
            'email' => 'user@example.com',
            'password' => 'wrong_password',
        ]);

        // Assertions
        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthorized',
            ]);
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Logout success']);
    }
}
