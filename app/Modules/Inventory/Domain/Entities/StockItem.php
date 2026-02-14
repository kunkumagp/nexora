<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Domain\Entities;

/**
 * StockItem domain entity
 */
class StockItem
{
    /**
     * @param string $id
     * @param string $name
     * @param int $quantity
     * @param string $branch_id
     */
    public function __construct(
        public string $id,
        public string $name,
        public int $quantity,
        public string $branch_id
    ) {}
    // ...other properties and methods
}
