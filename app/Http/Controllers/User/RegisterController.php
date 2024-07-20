<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Http\Requests\User\RegisterFormRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class RegisterController extends BaseController
{
    public function store(RegisterFormRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $user = User::create($validatedData);

        return response()->json(['message' => 'User registered successfully', 'user' => new UserResource($user)], 201);
    }
}
