<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Http\Requests\User\LoginFormRequest;
use App\Services\UserAuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends BaseController
{
    public function __construct(
        protected UserAuthService $authService
    ) {}

    public function store(LoginFormRequest $request): JsonResponse
    {
        $result = $this->authService->authenticate($request->only('email', 'password'));

        $status = is_numeric($result['status']) ? intval($result['status']) : 500;

        return response()->json($result, $status);
    }
}
