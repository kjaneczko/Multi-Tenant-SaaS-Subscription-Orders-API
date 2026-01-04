<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Product;

use App\Application\Common\Query\PageRequest;
use App\Domain\Product\Interface\ProductQueryInterface;
use App\Models\ProductModel;

final readonly class ProductQueryEloquent implements ProductQueryInterface
{
    public function paginate(PageRequest $pageRequest, ?string $tenantId = null): array
    {
        $page = $pageRequest->page;
        $limit = $pageRequest->limit;

        $query = ProductModel::query()->orderByDesc('created_at');

        if (null !== $tenantId && '' !== $tenantId) {
            $query->where('tenant_id', $tenantId);
        }

        $models = $query
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get()
        ;

        return $models
            ->map(fn (ProductModel $model) => ProductPersistenceMapper::toDomain($model))
            ->all()
        ;
    }
}
