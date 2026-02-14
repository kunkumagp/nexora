<?php
declare(strict_types=1);

namespace App\Modules\Inventory\Infrastructure\Listeners;

use App\Modules\POS\Domain\Events\InvoiceCreated;
use App\Modules\Inventory\Infrastructure\Persistence\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DeductStockOnInvoice
{
    public function handle(InvoiceCreated $event): void
    {
        DB::transaction(function () use ($event) {
            foreach ($event->items as $item) {
                $currentStock = StockMovement::getStock($item['company_id'], $item['product_id'], $item['warehouse_id']);
                if ($currentStock < $item['quantity']) {
                    // Optionally log or throw exception
                    continue;
                }
                StockMovement::create([
                    'id' => (string) Str::uuid(),
                    'company_id' => $item['company_id'],
                    'warehouse_id' => $item['warehouse_id'],
                    'product_id' => $item['product_id'],
                    'type' => 'out',
                    'quantity' => $item['quantity'],
                    'reference_type' => 'invoice',
                    'reference_id' => $event->invoiceId,
                    'user_id' => $item['user_id'] ?? null,
                ]);
            }
        });
    }
}
