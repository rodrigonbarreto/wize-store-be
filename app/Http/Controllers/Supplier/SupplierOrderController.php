<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\BaseController;
use App\Http\Resources\User\UserResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierOrderController extends BaseController
{
    public function __construct() {}

    public function index(): JsonResource
    {

        $users = Product::where('supplier_id', $this->getUser()->id)
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('users.*')
            ->distinct()
            ->get();

        return UserResource::collection($users);

    }
}
