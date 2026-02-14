<?php

declare(strict_types=1);

namespace App\Modules\Core\Infrastructure\Persistence;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes;

    protected $table = 'branches';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id', 'company_id', 'name', 'address'
    ];

    public function warehouses()
    {
        return $this->hasMany(\App\Modules\Inventory\Infrastructure\Persistence\Warehouse::class);
    }
}
