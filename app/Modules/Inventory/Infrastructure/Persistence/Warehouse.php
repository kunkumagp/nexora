<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Infrastructure\Persistence;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use SoftDeletes;

    protected $table = 'warehouses';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id', 'company_id', 'branch_id', 'name', 'location'
    ];

    public function branch()
    {
        return $this->belongsTo(\App\Modules\Core\Infrastructure\Persistence\Branch::class);
    }
}
