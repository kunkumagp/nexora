<?php

declare(strict_types=1);

namespace App\Modules\Core\Infrastructure\Persistence;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    protected $table = 'users';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id', 'company_id', 'branch_id', 'role_id', 'name', 'email', 'password', 'phone'
    ];

    public function branch()
    {
        return $this->belongsTo(\App\Modules\Core\Infrastructure\Persistence\Branch::class);
    }
}
