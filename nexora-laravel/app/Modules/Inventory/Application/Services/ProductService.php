<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Services;

use App\Modules\Inventory\Infrastructure\Repositories\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProductService
{
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function list(string $companyId): array
    {
        return $this->productRepository->allByCompany($companyId);
    }

    public function find(string $companyId, string $id): ?array
    {
        return $this->productRepository->findByCompany($companyId, $id);
    }

    public function create(string $companyId, array $data): array
    {
        return DB::transaction(function () use ($companyId, $data) {
            return $this->productRepository->create($companyId, $data);
        });
    }

    public function update(string $companyId, string $id, array $data): ?array
    {
        return DB::transaction(function () use ($companyId, $id, $data) {
            return $this->productRepository->update($companyId, $id, $data);
        });
    }

    public function delete(string $companyId, string $id): bool
    {
        return DB::transaction(function () use ($companyId, $id) {
            return $this->productRepository->delete($companyId, $id);
        });
    }
}
