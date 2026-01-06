<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Order;

use App\Application\Common\Query\PageRequest;
use App\Domain\Order\Interface\OrderQueryInterface;
use App\Domain\Order\Order;
use App\Domain\Order\OrderId;
use App\Domain\Tenant\TenantId;
use App\Models\OrderModel;

final readonly class OrderQueryEloquent implements OrderQueryInterface
{
    public function getById(OrderId $id): ?Order
    {
        $model = OrderModel::query()->whereKey($id->toString())->first();
        if (!$model) {
            return null;
        }

        return OrderPersistenceMapper::toDomain($model);
    }

    public function paginate(PageRequest $pageRequest, ?TenantId $tenantId = null): array
    {
        $page = $pageRequest->page;
        $limit = $pageRequest->limit;

        $query = OrderModel::query()->orderByDesc('created_at');

        if (null !== $tenantId) {
            $query->where('tenant_id', $tenantId->toString());
        }

        $models = $query
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get()
        ;

        return $models
            ->map(fn (OrderModel $model) => OrderPersistenceMapper::toDomain($model))
            ->all()
        ;
    }
}
