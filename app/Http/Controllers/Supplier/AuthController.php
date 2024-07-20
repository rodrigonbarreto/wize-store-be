<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Supplier\LoginFormRequest;
use App\Services\SupplierAuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends BaseController
{
    public function __construct(protected SupplierAuthService $authService) {}

    public function store(LoginFormRequest $request): JsonResponse
    {
        $result = $this->authService->authenticate($request->only('email', 'password'));

        $status = is_numeric($result['status']) ? intval($result['status']) : 500;

        return response()->json($result, $status);
    }
}
