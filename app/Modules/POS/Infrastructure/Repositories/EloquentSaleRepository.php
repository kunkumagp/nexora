<?php

namespace App\Modules\POS\Infrastructure\Repositories;

use App\Modules\POS\Domain\Entities\Sale;
use App\Modules\POS\Infrastructure\Persistence\SaleModel;

class EloquentSaleRepository implements SaleRepositoryInterface
{
    public function find(string $id): ?Sale
    {
        $model = SaleModel::find($id);
        if (!$model) return null;
        return new Sale($model->id, $model->item_id, $model->quantity, $model->branch_id, $model->user_id, $model->created_at);
    }

    public function save(Sale $sale): void
    {
        $model = SaleModel::find($sale->id) ?? new SaleModel();
        $model->id = $sale->id;
        $model->item_id = $sale->item_id;
        $model->quantity = $sale->quantity;
        $model->branch_id = $sale->branch_id;
        $model->user_id = $sale->user_id;
        $model->created_at = $sale->created_at;
        $model->save();
    }
}
