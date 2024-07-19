<?php

namespace Tests\Unit\Models;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_order()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'status' => 'pending',
            'total_price' => 100.0,
        ]);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals($user->id, $order->user_id);
        $this->assertEquals('pending', $order->status);
        $this->assertEquals(100.0, $order->total_price);
    }

    /** @test */
    public function it_calculates_total_order_price_correctly()
    {
        $order = Order::factory()->create();
        OrderItem::factory()->create(['order_id' => $order->id, 'price' => 50.0, 'quantity' => 2]);
        OrderItem::factory()->create(['order_id' => $order->id, 'price' => 30.0, 'quantity' => 1]);

        $calculatedTotal = $order->orderItems->sum(fn ($item) => $item->price * $item->quantity);
        $order->total_price = $calculatedTotal;
        $order->save();

        $this->assertEquals($calculatedTotal, $order->total);
        $this->assertEquals($order->total, $order->total_price);
    }
}
