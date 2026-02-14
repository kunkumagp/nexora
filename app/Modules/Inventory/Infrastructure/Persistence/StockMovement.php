<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Infrastructure\Persistence;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockMovement extends Model
{
    use SoftDeletes;

    protected $table = 'stock_movements';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id', 'company_id', 'warehouse_id', 'product_id', 'type', 'quantity', 'reference_type', 'reference_id', 'user_id', 'note'
    ];

    public static function getStock(string $companyId, string $productId, string $warehouseId): int
    {
        $in = static::where('company_id', $companyId)
            ->where('product_id', $productId)
            ->where('warehouse_id', $warehouseId)
            ->where('type', 'in')
            ->sum('quantity');
        $out = static::where('company_id', $companyId)
            ->where('product_id', $productId)
            ->where('warehouse_id', $warehouseId)
            ->where('type', 'out')
            ->sum('quantity');
        return $in - $out;
    }
}
