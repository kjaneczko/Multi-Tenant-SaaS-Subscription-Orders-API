<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\OrderItem;

use App\Application\Common\Query\PageRequest;
use App\Domain\OrderItem\Interface\OrderItemQueryInterface;
use App\Domain\OrderItem\OrderItem;
use App\Domain\OrderItem\OrderItemId;
use App\Domain\Tenant\TenantId;
use App\Models\OrderItemModel;

final readonly class OrderItemQueryEloquent implements OrderItemQueryInterface
{
    public function getById(OrderItemId $id): ?OrderItem
    {
        $model = OrderItemModel::query()->whereKey($id->toString())->first();
        if (!$model) {
            return null;
        }

        return OrderItemPersistenceMapper::toDomain($model);
    }

    public function paginate(PageRequest $pageRequest, ?TenantId $tenantId = null, ?string $orderId = null): array
    {
        $page = $pageRequest->page;
        $limit = $pageRequest->limit;

        $query = OrderItemModel::query()->orderByDesc('created_at');

        if (null !== $tenantId) {
            $query->where('tenant_id', $tenantId->toString());
        }

        if (null !== $orderId) {
            $query->where('order_id', $orderId);
        }

        $models = $query
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get()
        ;

        return $models
            ->map(fn (OrderItemModel $model) => OrderItemPersistenceMapper::toDomain($model))
            ->all()
        ;
    }
}
