<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Services;

use App\Modules\Inventory\Infrastructure\Persistence\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use DomainException;

class InventoryService
{
    /**
     * Transfer stock between warehouses.
     */
    public function transfer(string $companyId, string $productId, string $fromWarehouseId, string $toWarehouseId, int $quantity, string $userId): void
    {
        DB::transaction(function () use ($companyId, $productId, $fromWarehouseId, $toWarehouseId, $quantity, $userId) {
            $currentStock = StockMovement::getStock($companyId, $productId, $fromWarehouseId);
            if ($currentStock < $quantity) {
                throw new DomainException('Insufficient stock in source warehouse');
            }
            StockMovement::create([
                'id' => (string) Str::uuid(),
                'company_id' => $companyId,
                'warehouse_id' => $fromWarehouseId,
                'product_id' => $productId,
                'type' => 'out',
                'quantity' => $quantity,
                'reference_type' => 'transfer',
                'reference_id' => null,
                'user_id' => $userId,
            ]);
            StockMovement::create([
                'id' => (string) Str::uuid(),
                'company_id' => $companyId,
                'warehouse_id' => $toWarehouseId,
                'product_id' => $productId,
                'type' => 'in',
                'quantity' => $quantity,
                'reference_type' => 'transfer',
                'reference_id' => null,
                'user_id' => $userId,
            ]);
        });
    }

    /**
     * Adjust stock in a warehouse (positive or negative).
     */
    public function adjust(string $companyId, string $productId, string $warehouseId, int $quantity, string $reason, string $userId): void
    {
        DB::transaction(function () use ($companyId, $productId, $warehouseId, $quantity, $reason, $userId) {
            $currentStock = StockMovement::getStock($companyId, $productId, $warehouseId);
            if ($currentStock + $quantity < 0) {
                throw new DomainException('Adjustment would result in negative stock');
            }
            StockMovement::create([
                'id' => (string) Str::uuid(),
                'company_id' => $companyId,
                'warehouse_id' => $warehouseId,
                'product_id' => $productId,
                'type' => $quantity > 0 ? 'in' : 'out',
                'quantity' => abs($quantity),
                'reference_type' => 'adjustment',
                'reference_id' => null,
                'user_id' => $userId,
                'note' => $reason,
            ]);
        });
    }

    /**
     * Get stock movement history for a product in a warehouse.
     */
    public function movementHistory(string $companyId, string $productId, string $warehouseId): array
    {
        return StockMovement::where('company_id', $companyId)
            ->where('product_id', $productId)
            ->where('warehouse_id', $warehouseId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }

    /**
     * FIFO inventory valuation outline (pseudo-code):
     * 1. Fetch all 'in' movements for product, ordered by date.
     * 2. For each sale ('out'), consume from oldest 'in' until quantity is fulfilled.
     * 3. Track cost per batch for COGS.
     */
}
