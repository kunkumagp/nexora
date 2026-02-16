<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Infrastructure\Repositories;

interface ProductRepositoryInterface
{
    public function allByCompany(string $companyId): array;
    public function findByCompany(string $companyId, string $id): ?array;
    public function create(string $companyId, array $data): array;
    public function update(string $companyId, string $id, array $data): ?array;
    public function delete(string $companyId, string $id): bool;
}
