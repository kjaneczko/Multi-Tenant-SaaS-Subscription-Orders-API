<?php

namespace App\Infrastructure\Database\Product;

use App\Application\Product\Interface\ProductQueryInterface;
use App\Application\Shared\Query\PageRequest;
use App\Models\ProductModel;

final readonly class ProductQueryEloquent implements ProductQueryInterface
{
    public function paginate(PageRequest $pageRequest, ?string $tenantId = null): array
    {
        // Jeśli u Ciebie PageRequest ma gettery – zamień na:
        // $page = $pageRequest->page();
        // $limit = $pageRequest->limit();
        $page = $pageRequest->page;
        $limit = $pageRequest->limit;

        $query = ProductModel::query()->orderByDesc('created_at');

        if ($tenantId !== null && $tenantId !== '') {
            $query->where('tenant_id', $tenantId);
        }

        $models = $query
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get();

        return $models
            ->map(fn (ProductModel $model) => ProductPersistenceMapper::toDomain($model))
            ->all();
    }
}
