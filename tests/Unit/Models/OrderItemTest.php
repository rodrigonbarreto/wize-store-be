<?php

namespace Tests\Unit\Models;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_order_item()
    {
        $order = Order::factory()->create();
        $product = Product::factory()->create();
        $orderItem = OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 50.0,
        ]);

        $this->assertInstanceOf(OrderItem::class, $orderItem);
        $this->assertEquals($order->id, $orderItem->order_id);
        $this->assertEquals($product->id, $orderItem->product_id);
        $this->assertEquals(2, $orderItem->quantity);
        $this->assertEquals(50.0, $orderItem->price);
    }
}
