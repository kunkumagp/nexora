<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Infrastructure\Listeners;

use App\Modules\Inventory\Domain\Events\StockUpdated;

/**
 * Listener for StockUpdated event to update stock ledger
 */
class UpdateStockLedger
{
    /**
     * Handle the event.
     *
     * @param StockUpdated $event
     * @return void
     */
    public function handle(StockUpdated $event): void
    {
        // Update stock ledger logic here
        // ...
    }
}
