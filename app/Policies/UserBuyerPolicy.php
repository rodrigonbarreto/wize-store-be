<?php

namespace App\Policies;

use App\Enums\UserType;
use App\Models\User;

class UserBuyerPolicy
{
    /**
     * Determine whether the user can view the buyers.
     */
    public function viewBuyers(User $user): bool
    {
        return $user->type === UserType::Supplier->value;
    }
}
