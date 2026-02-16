<?php

namespace App\Modules\Inventory\Presentation\Http\Controllers;

use App\Modules\Inventory\Application\Services\StockService;
use App\Modules\Inventory\Presentation\Http\Requests\UpdateStockRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Class StockController
 * @package App\Modules\Inventory\Presentation\Http\Controllers
 */
class StockController
{
    protected StockService $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    /**
     * Update stock for an item.
     *
     * @param UpdateStockRequest $request
     * @return JsonResponse
     */
    public function update(UpdateStockRequest $request): JsonResponse
    {
        try {
            // Optionally, check user permissions here for RBAC
            $this->stockService->updateStock($request->validated('item_id'), $request->validated('quantity'));
            return response()->json(['message' => 'Stock updated'], 200);
        } catch (\DomainException $e) {
            Log::warning('Domain error updating stock', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (Throwable $e) {
            Log::error('Unexpected error updating stock', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
}
