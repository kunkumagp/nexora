<?php

declare(strict_types=1);

namespace App\Modules\POS\Infrastructure\Persistence;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $table = 'invoices';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id', 'company_id', 'branch_id', 'customer_id', 'user_id', 'invoice_date', 'total', 'paid', 'status'
    ];

    public function branch()
    {
        return $this->belongsTo(\App\Modules\Core\Infrastructure\Persistence\Branch::class);
    }
}
