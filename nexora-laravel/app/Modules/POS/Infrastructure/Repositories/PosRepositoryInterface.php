<?php
declare(strict_types=1);

namespace App\Modules\POS\Infrastructure\Repositories;

interface PosRepositoryInterface
{
    public function addToCart(string $userId, array $data): array;
    public function updateCart(string $userId, array $data): array;
    public function hasSufficientStock(array $items): bool;
    public function createInvoice(string $userId, array $data): array;
    public function refund(string $userId, array $data): array;
    public function openShift(string $userId, array $data): array;
    public function closeShift(string $userId, array $data): array;
}
