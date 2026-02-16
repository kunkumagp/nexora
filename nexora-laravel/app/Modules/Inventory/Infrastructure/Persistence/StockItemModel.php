<?php

namespace App\Modules\Inventory\Infrastructure\Persistence;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Traits\UsesUuid;

class StockItemModel extends Model
{
    use UsesUuid;
    protected $table = 'stock_items';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['id', 'name', 'quantity', 'branch_id'];
}
