<?php

namespace Tests\Unit\Controllers\Supplier;

use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_register_a_supplier()
    {
        $supplierData = [
            'name' => 'Test Supplier',
            'email' => 'test@supplier.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'store_name' => 'Test Store',
        ];

        $response = $this->postJson('/api/v1/supplier/register', $supplierData);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Supplier registered successfully',
                'supplier' => [
                    'name' => 'Test Supplier',
                    'email' => 'test@supplier.com',
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@supplier.com',
            'type' => 'supplier',
        ]);
    }

    /** @test */
    public function it_returns_validation_error_when_required_fields_are_missing()
    {
        $response = $this->postJson('/api/v1/supplier/register', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password', 'store_name']);
    }

    /** @test */
    public function it_returns_error_if_email_is_already_taken()
    {
        Supplier::factory()->create(['email' => 'test@supplier.com']);

        $supplierData = [
            'name' => 'Test Supplier',
            'email' => 'test@supplier.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'store_name' => 'Test Store',
        ];

        $response = $this->postJson('/api/v1/supplier/register', $supplierData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
