<?php

namespace Tests\Unit\Controllers\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_login_a_user()
    {
        $user = User::factory()->create(
            [
                'password' => bcrypt($password = 'password123'),
                'type' => 'user',
            ]
        );

        $response = $this->postJson('/api/v1/user/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'user',
            ]);
    }

    /** @test */
    public function it_returns_error_with_invalid_credentials()
    {
        $user = User::factory()->create(['password' => bcrypt('password123')]);

        $response = $this->postJson('/api/v1/user/login', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'error' => 'The provided credentials do not match our records.',
            ]);
    }

    /** @test */
    public function it_returns_error_if_user_is_not_user_type()
    {
        $supplier = User::factory()->create(['password' => bcrypt('password123'), 'type' => 'supplier']);

        $response = $this->postJson('/api/v1/user/login', [
            'email' => $supplier->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(403)
            ->assertJson([
                'error' => 'This route is not authorized for your user type.',
            ]);
    }
}
