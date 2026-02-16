<?php

namespace App\Modules\POS\Presentation\Http\Controllers;

use App\Modules\POS\Application\Services\SaleService;
use App\Modules\POS\Domain\Entities\Sale;
use App\Modules\POS\Presentation\Http\Requests\CreateSaleRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SaleController
{
    protected SaleService $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function store(CreateSaleRequest $request): JsonResponse
    {
        $sale = new Sale(
            (string) Str::uuid(),
            $request->item_id,
            $request->quantity,
            $request->branch_id,
            $request->user_id,
            Carbon::now()->toDateTimeString()
        );
        $this->saleService->createSale($sale);
        return response()->json(['message' => 'Sale recorded']);
    }
}
