<?php

namespace App\Policies;

use App\Enums\UserType;
use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Product $product): bool
    {
        return true;
    }

    public function store(User $user): bool
    {
        return $user->type === UserType::Supplier->value;
    }

    public function update(User $user, Product $product): bool
    {
        return $user->type === UserType::Supplier->value && $user->id === $product->supplier_id;
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->type === UserType::Supplier->value && $user->id === $product->supplier_id;
    }
}
