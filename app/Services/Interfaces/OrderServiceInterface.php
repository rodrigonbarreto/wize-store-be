<?php

namespace App\Services\Interfaces;

use App\Models\User;

interface OrderServiceInterface
{
    /**
     * @param  array<int, mixed>  $products
     * @return mixed
     */
    public function createOrder(array $products, User $user);
}
