<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Product;

use App\Application\Common\Query\PageRequest;
use App\Domain\Product\Interface\ProductQueryInterface;
use App\Domain\Product\Product;
use App\Domain\Product\ProductId;
use App\Domain\Tenant\TenantId;
use App\Models\ProductModel;

final readonly class ProductQueryEloquent implements ProductQueryInterface
{
    public function getById(ProductId $id): ?Product
    {
        $model = ProductModel::query()->find($id->toString());
        if (!$model) {
            return null;
        }

        return ProductPersistenceMapper::toDomain($model);
    }
    public function paginate(PageRequest $pageRequest, ?TenantId $tenantId = null): array
    {
        $page = $pageRequest->page;
        $limit = $pageRequest->limit;

        $query = ProductModel::query()->orderByDesc('created_at');

        if (null !== $tenantId) {
            $query->where('tenant_id', $tenantId->toString());
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
