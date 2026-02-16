<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Presentation\Http\Controllers;

use App\Modules\Inventory\Application\Services\ProductService;
use App\Modules\Inventory\Presentation\Http\Requests\ProductRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ProductController
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request): JsonResponse
    {
        $companyId = Auth::user()->company_id;
        $products = $this->productService->list($companyId);
        return response()->json($products);
    }

    public function show(string $id): JsonResponse
    {
        $companyId = Auth::user()->company_id;
        $product = $this->productService->find($companyId, $id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        return response()->json($product);
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $companyId = Auth::user()->company_id;
        $product = $this->productService->create($companyId, $request->validated());
        return response()->json($product, 201);
    }

    public function update(ProductRequest $request, string $id): JsonResponse
    {
        $companyId = Auth::user()->company_id;
        $product = $this->productService->update($companyId, $id, $request->validated());
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        return response()->json($product);
    }

    public function destroy(string $id): JsonResponse
    {
        $companyId = Auth::user()->company_id;
        $deleted = $this->productService->delete($companyId, $id);
        if (!$deleted) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        return response()->json(['message' => 'Product deleted']);
    }
}
