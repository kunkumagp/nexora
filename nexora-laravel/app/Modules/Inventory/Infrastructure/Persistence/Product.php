<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Infrastructure\Persistence;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Shared\Traits\UsesUuid;

class Product extends Model
{
    use UsesUuid, SoftDeletes;

    protected $table = 'products';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id', 'company_id', 'category_id', 'name', 'sku', 'barcode', 'price', 'unit', 'description'
    ];
}
