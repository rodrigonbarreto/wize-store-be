<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartFormRequest;
use App\Services\Interfaces\OrderServiceInterface;
use Illuminate\Http\JsonResponse;

class CartController extends BaseController
{
    public function __construct(protected OrderServiceInterface $orderService) {}

    public function checkout(CartFormRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if (! is_array($validated['products'])) {
            return response()->json(['message' => 'Invalid products data'], 400);
        }

        try {
            $order = $this->orderService->createOrder($validated['products'], $this->getUser());

            return response()->json(['message' => 'Order completed successfully', 'order' => $order], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Order failed', 'error' => $e->getMessage()], 500);
        }
    }
}
