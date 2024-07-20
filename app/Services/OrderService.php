<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Services\Interfaces\OrderServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OrderService implements OrderServiceInterface
{
    /**
     * @param  array<int, array<string, int>>  $products
     *
     * @throws \Exception
     */
    public function createOrder(array $products, User $user): Order
    {
        DB::beginTransaction();

        try {
            $cart = collect($products);

            $totalPrice = $this->calculateTotalPrice($cart);

            $order = $this->createNewOrder($totalPrice, $user);

            $this->createOrderItems($order, $cart);

            DB::commit();

            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param  Collection<int, array<string, int>>  $cart
     */
    protected function calculateTotalPrice(Collection $cart): float
    {
        return $cart->reduce(function ($carry, $item) {
            $product = Product::findOrFail($item['product_id']);

            return $carry + ($product->price * $item['quantity']);
        }, 0);
    }

    protected function createNewOrder(float $totalPrice, User $user): Order
    {
        return Order::create([
            'user_id' => $user->id,
            'total_price' => $totalPrice,
            'status' => 'completed',
        ]);
    }

    /**
     * @param  Collection<int, array<string, int>>  $cart
     */
    protected function createOrderItems(Order $order, Collection $cart): void
    {
        foreach ($cart as $item) {
            $product = Product::findOrFail($item['product_id']);
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ]);
        }
    }
}
