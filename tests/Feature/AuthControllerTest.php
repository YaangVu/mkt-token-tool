<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_clientSignInWithValidCredentials()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'username' => 'testuser',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/client/login', [
            'username' => 'testuser',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'code',
                     'data' => [
                         'username',
                         'token',
                         'teams',
                         'childStatus',
                         'versions',
                     ],
                     'message',
                     'serviceTime',
                 ]);
    }

    public function test_clientSignInWithInvalidCredentials()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'username' => 'testuser',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/client/login', [
            'username' => 'testuser',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                     'code' => 401,
                     'message' => 'Invalid credentials',
                 ]);
    }

    public function test_clientSignInWithNonExistentUser()
    {
        $response = $this->postJson('/api/client/login', [
            'username' => 'nonexistentuser',
            'password' => 'password123',
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                     'code' => 401,
                     'message' => 'Invalid credentials',
                 ]);
    }

    public function test_clientSignInWithMissingUsername()
    {
        $response = $this->postJson('/api/client/login', [
            'password' => 'password123',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['username']);
    }

    public function test_clientSignInWithMissingPassword()
    {
        $response = $this->postJson('/api/client/login', [
            'username' => 'testuser',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['password']);
    }
}
