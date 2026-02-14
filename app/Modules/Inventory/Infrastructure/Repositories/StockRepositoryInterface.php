<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Infrastructure\Repositories;

use App\Modules\Inventory\Domain\Entities\StockItem;

/**
 * Interface for stock repository
 */
interface StockRepositoryInterface
{
    /**
     * Find a stock item by UUID.
     *
     * @param string $id
     * @return StockItem|null
     */
    public function find(string $id): ?StockItem;

    /**
     * Save or update a stock item.
     *
     * @param StockItem $item
     * @return void
     */
    public function save(StockItem $item): void;
    // ...other methods
}
