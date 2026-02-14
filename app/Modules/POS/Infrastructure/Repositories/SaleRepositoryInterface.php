<?php

namespace App\Modules\POS\Infrastructure\Repositories;

use App\Modules\POS\Domain\Entities\Sale;

interface SaleRepositoryInterface
{
    public function find(string $id): ?Sale;
    public function save(Sale $sale): void;
    // ...other methods
}
