<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Domain\Events;

/**
 * Event triggered when stock is updated
 */
class StockUpdated
{
    public string $itemId;
    public int $quantity;

    public function __construct(string $itemId, int $quantity)
    {
        $this->itemId = $itemId;
        $this->quantity = $quantity;
    }
}
