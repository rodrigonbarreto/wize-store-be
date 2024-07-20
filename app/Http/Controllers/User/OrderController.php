<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        $user = $this->getUser();

        return OrderResource::collection($user->orders);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): OrderResource
    {
        return new OrderResource($order);
    }
}
