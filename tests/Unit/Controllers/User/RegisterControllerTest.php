<?php

namespace Tests\Unit\Controllers\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_register_a_user()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@user.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/v1/user/register', $userData);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'User registered successfully',
                'user' => [
                    'name' => 'Test User',
                    'email' => 'test@user.com',
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@user.com',
        ]);
    }

    /** @test */
    public function it_returns_validation_error_when_required_fields_are_missing()
    {
        $response = $this->postJson('/api/v1/user/register', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    /** @test */
    public function it_returns_error_if_email_is_already_taken()
    {
        User::factory()->create(['email' => 'test@user.com']);

        $userData = [
            'name' => 'Test User',
            'email' => 'test@user.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/v1/user/register', $userData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
