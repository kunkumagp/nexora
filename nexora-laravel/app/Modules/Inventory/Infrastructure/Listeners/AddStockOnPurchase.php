<?php
declare(strict_types=1);

namespace App\Modules\Inventory\Infrastructure\Listeners;

use App\Modules\Inventory\Domain\Events\PurchaseCompleted;
use App\Modules\Inventory\Infrastructure\Persistence\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AddStockOnPurchase
{
    public function handle(PurchaseCompleted $event): void
    {
        DB::transaction(function () use ($event) {
            foreach ($event->items as $item) {
                StockMovement::create([
                    'id' => (string) Str::uuid(),
                    'company_id' => $item['company_id'],
                    'warehouse_id' => $item['warehouse_id'],
                    'product_id' => $item['product_id'],
                    'type' => 'in',
                    'quantity' => $item['quantity'],
                    'reference_type' => 'purchase',
                    'reference_id' => $event->purchaseId,
                    'user_id' => $item['user_id'] ?? null,
                ]);
            }
        });
    }
}
