<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Infrastructure\Repositories;

use App\Modules\Inventory\Domain\Entities\StockItem;
use App\Modules\Inventory\Infrastructure\Persistence\StockItemModel;

/**
 * Eloquent implementation of StockRepositoryInterface
 */
class EloquentStockRepository implements StockRepositoryInterface
{
    /**
     * Find a stock item by UUID.
     *
     * @param string $id
     * @return StockItem|null
     */
    public function find(string $id): ?StockItem
    {
        $model = StockItemModel::select(['id', 'name', 'quantity', 'branch_id'])->find($id);
        if (!$model) return null;
        return new StockItem($model->id, $model->name, $model->quantity, $model->branch_id);
    }

    /**
     * Save or update a stock item using upsert for performance.
     *
     * @param StockItem $item
     * @return void
     */
    public function save(StockItem $item): void
    {
        StockItemModel::updateOrCreate(
            ['id' => $item->id],
            [
                'name' => $item->name,
                'quantity' => $item->quantity,
                'branch_id' => $item->branch_id,
            ]
        );
    }
}
