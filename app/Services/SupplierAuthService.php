<?php

namespace App\Services;

use App\Enums\UserType;
use App\Models\User;

class SupplierAuthService extends BaseAuthService
{
    /**
     * Check if the user type is Supplier.
     */
    protected function checkUserType(User $user): bool
    {
        return $user->type === UserType::Supplier->value;
    }
}
