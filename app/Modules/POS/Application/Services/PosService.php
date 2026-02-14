<?php

declare(strict_types=1);

namespace App\Modules\POS\Application\Services;

use App\Modules\POS\Infrastructure\Repositories\PosRepositoryInterface;
use App\Modules\POS\Domain\Events\InvoiceCreated;
use Illuminate\Support\Facades\DB;

class PosService
{
    protected PosRepositoryInterface $posRepository;

    public function __construct(PosRepositoryInterface $posRepository)
    {
        $this->posRepository = $posRepository;
    }

    public function addToCart(string $userId, array $data): array
    {
        return $this->posRepository->addToCart($userId, $data);
    }

    public function updateCart(string $userId, array $data): array
    {
        return $this->posRepository->updateCart($userId, $data);
    }

    public function checkout(string $userId, array $data): array
    {
        return DB::transaction(function () use ($userId, $data) {
            // Check stock for all items
            if (!$this->posRepository->hasSufficientStock($data['items'])) {
                throw new \DomainException('Insufficient stock for one or more items');
            }
            $invoice = $this->posRepository->createInvoice($userId, $data);
            event(new InvoiceCreated($invoice['id'], $invoice['items']));
            return $invoice;
        });
    }

    public function refund(string $userId, array $data): array
    {
        return DB::transaction(function () use ($userId, $data) {
            return $this->posRepository->refund($userId, $data);
        });
    }

    public function openShift(string $userId, array $data): array
    {
        return $this->posRepository->openShift($userId, $data);
    }

    public function closeShift(string $userId, array $data): array
    {
        return $this->posRepository->closeShift($userId, $data);
    }
}
