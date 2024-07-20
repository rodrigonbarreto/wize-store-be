<?php

namespace App\Services;

use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;

abstract class BaseAuthService implements AuthServiceInterface
{
    /**
     * @param  array<string, string>  $credentials
     * @return array<string, mixed>
     */
    public function authenticate(array $credentials): array
    {
        if (! Auth::attempt($credentials)) {
            return ['error' => 'The provided credentials do not match our records.', 'status' => 401];
        }

        /** @var User|null $user */
        $user = Auth::user();

        if (! $user || ! $this->checkUserType($user)) {
            Auth::logout();

            return ['error' => 'This route is not authorized for your user type.', 'status' => 403];
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $this->getUserResource($user),
            'status' => 200,
        ];
    }

    abstract protected function checkUserType(User $user): bool;

    protected function getUserResource(User $user): UserResource
    {
        return new UserResource($user);
    }
}
