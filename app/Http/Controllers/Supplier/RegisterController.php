<?php

namespace App\Http\Controllers\Supplier;

use App\Enums\UserType;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Supplier\RegisterFormRequest;
use App\Http\Resources\Supplier\UserResource;
use App\Models\Supplier;
use Illuminate\Http\JsonResponse;

class RegisterController extends BaseController
{
    public function store(RegisterFormRequest $request): JsonResponse
    {
        $validateData = $request->validated();
        $validateData['type'] = UserType::Supplier;

        $supplier = Supplier::create($validateData);

        return response()->json([
            'message' => 'Supplier registered successfully', 'supplier' => new UserResource($supplier)], 201
        );
    }
}
