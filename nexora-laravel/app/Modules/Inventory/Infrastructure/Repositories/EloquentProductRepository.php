<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Infrastructure\Repositories;

use App\Modules\Inventory\Infrastructure\Persistence\Product;
use Illuminate\Support\Str;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function allByCompany(string $companyId): array
    {
        return Product::where('company_id', $companyId)->get()->toArray();
    }

    public function findByCompany(string $companyId, string $id): ?array
    {
        $product = Product::where('company_id', $companyId)->where('id', $id)->first();
        return $product ? $product->toArray() : null;
    }

    public function create(string $companyId, array $data): array
    {
        $data['id'] = (string) Str::uuid();
        $data['company_id'] = $companyId;
        $product = Product::create($data);
        return $product->toArray();
    }

    public function update(string $companyId, string $id, array $data): ?array
    {
        $product = Product::where('company_id', $companyId)->where('id', $id)->first();
        if (!$product) return null;
        $product->update($data);
        return $product->toArray();
    }

    public function delete(string $companyId, string $id): bool
    {
        $product = Product::where('company_id', $companyId)->where('id', $id)->first();
        if (!$product) return false;
        $product->delete();
        return true;
    }
}
