<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(): JsonResource
    {
        return ProductResource::collection(Product::all());
    }

    public function store(ProductRequest $request): JsonResource
    {
        $validatedData = $request->validated();
        $validatedData['supplier_id'] = Auth::id();

        $product = Product::create($validatedData);

        return new ProductResource($product);
    }

    public function show(Product $product): JsonResource
    {
        return new ProductResource($product);
    }

    public function update(ProductRequest $request, Product $product): JsonResource
    {
        $product->update($request->validated());

        return new ProductResource($product);
    }

    public function destroy(Product $product): Response
    {
        $product->delete();

        return response()->noContent();
    }
}
