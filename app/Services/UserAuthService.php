<?php

namespace App\Services;

use App\Enums\UserType;
use App\Models\User;

class UserAuthService extends BaseAuthService
{
    protected function checkUserType(User $user): bool
    {
        return $user->type === UserType::User->value;
    }
}
