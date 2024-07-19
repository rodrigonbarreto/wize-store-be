<?php

namespace Tests\Unit\Models;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_product()
    {
        $supplier = Supplier::factory()->create();
        $product = Product::factory()->create([
            'supplier_id' => $supplier->id,
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 100.0,
            'stock' => 10,
            'image' => 'test_image.png',
        ]);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals($supplier->id, $product->supplier_id);
        $this->assertEquals('Test Product', $product->name);
        $this->assertEquals('Test Description', $product->description);
        $this->assertEquals(100.0, $product->price);
        $this->assertEquals(10, $product->stock);
        $this->assertEquals('test_image.png', $product->image);
    }
}
