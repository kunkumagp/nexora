<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Services;

use App\Modules\Inventory\Infrastructure\Repositories\StockRepositoryInterface;
use App\Modules\Inventory\Domain\Entities\StockItem;
use Illuminate\Support\Facades\DB;
use App\Modules\Inventory\Domain\Events\StockUpdated;

/**
 * Service for inventory stock operations.
 */
class StockService
{
    protected StockRepositoryInterface $stockRepository;

    public function __construct(StockRepositoryInterface $stockRepository)
    {
        $this->stockRepository = $stockRepository;
    }

    /**
     * Update stock for an item.
     *
     * @param string $itemId
     * @param int $qty
     * @throws \DomainException
     */
    public function updateStock(string $itemId, int $qty): void
    {
        $event = null;
        DB::transaction(function () use ($itemId, $qty, &$event) {
            $item = $this->stockRepository->find($itemId);
            if (!$item) {
                throw new \DomainException('Item not found');
            }
            $item->quantity += $qty;
            $this->stockRepository->save($item);
            $event = new StockUpdated($item->id, $item->quantity);
        });
        if ($event) {
            event($event);
        }
    }
}
