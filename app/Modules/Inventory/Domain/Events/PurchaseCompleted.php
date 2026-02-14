<?php
declare(strict_types=1);

namespace App\Modules\Inventory\Domain\Events;

class PurchaseCompleted
{
    public string $purchaseId;
    public array $items;

    public function __construct(string $purchaseId, array $items)
    {
        $this->purchaseId = $purchaseId;
        $this->items = $items;
    }
}
