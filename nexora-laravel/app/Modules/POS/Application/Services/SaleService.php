<?php

namespace App\Modules\POS\Application\Services;

use App\Modules\POS\Infrastructure\Repositories\SaleRepositoryInterface;
use App\Modules\POS\Domain\Entities\Sale;
use Illuminate\Support\Facades\DB;

class SaleService
{
    protected SaleRepositoryInterface $saleRepository;

    public function __construct(SaleRepositoryInterface $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    public function createSale(Sale $sale): void
    {
        DB::transaction(function () use ($sale) {
            $this->saleRepository->save($sale);
            event(new \App\Modules\Inventory\Domain\Events\StockUpdated($sale->item_id, -$sale->quantity));
        });
    }
}
