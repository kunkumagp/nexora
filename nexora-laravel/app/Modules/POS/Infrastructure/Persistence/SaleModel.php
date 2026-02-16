<?php

namespace App\Modules\POS\Infrastructure\Persistence;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Traits\UsesUuid;

class SaleModel extends Model
{
    use UsesUuid;
    protected $table = 'sales';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['id', 'item_id', 'quantity', 'branch_id', 'user_id', 'created_at'];
}
