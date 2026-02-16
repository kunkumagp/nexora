<?php
declare(strict_types=1);

namespace App\Modules\POS\Infrastructure\Listeners;

use App\Modules\POS\Domain\Events\InvoiceCreated;
use App\Modules\Inventory\Infrastructure\Persistence\StockItemModel;

class DeductStockOnInvoice
{
    public function handle(InvoiceCreated $event): void
    {
        foreach ($event->items as $item) {
            $stock = StockItemModel::where('id', $item['product_id'])->first();
            if ($stock && $stock->quantity >= $item['quantity']) {
                $stock->quantity -= $item['quantity'];
                $stock->save();
            } else {
                // Optionally log or throw exception for insufficient stock
            }
        }
    }
}
