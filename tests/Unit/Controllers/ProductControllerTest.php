<?php

namespace Tests\Unit\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->supplier = User::factory()->create(['type' => 'supplier']);
        $this->actingAs($this->supplier);
    }

    /** @test */
    public function it_can_list_all_products()
    {
        Product::factory()->count(3)->create(['supplier_id' => $this->supplier->id]);

        $response = $this->getJson(route('products.index'));

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    /** @test */
    public function it_can_show_a_product()
    {
        $product = Product::factory()->create(['supplier_id' => $this->supplier->id]);

        $response = $this->getJson(route('products.show', $product));

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image,
                    'supplier' => $this->supplier->name,
                ],
            ]);
    }

    /** @test */
    public function it_can_create_a_product()
    {
        $productData = [
            'name' => 'New Product',
            'description' => 'Product description',
            'price' => 99.99,
            'stock' => 10,
            'image' => 'http://example.com/image.jpg',
        ];

        $response = $this->postJson(route('products.store'), $productData);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => 'New Product',
                    'price' => 99.99,
                ],
            ]);

        $this->assertDatabaseHas('products', $productData);
    }

    /** @test */
    public function it_can_update_a_product()
    {
        $product = Product::factory()->create(['supplier_id' => $this->supplier->id]);

        $updateData = [
            'name' => 'Updated Product',
            'description' => $product->description,
            'price' => 49.99,
            'stock' => $product->stock,
            'image' => $product->image,
        ];

        $response = $this->putJson(route('products.update', $product), $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'Updated Product',
                    'price' => 49.99,
                ],
            ]);

        $this->assertDatabaseHas('products', $updateData);
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        $product = Product::factory()->create(['supplier_id' => $this->supplier->id]);

        $response = $this->deleteJson(route('products.destroy', $product));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
