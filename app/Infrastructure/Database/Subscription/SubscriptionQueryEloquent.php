<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Subscription;

use App\Application\Common\Query\PageRequest;
use App\Domain\Subscription\Interface\SubscriptionQueryInterface;
use App\Domain\Subscription\Subscription;
use App\Domain\Subscription\SubscriptionId;
use App\Domain\Subscription\SubscriptionStatus;
use App\Domain\Tenant\TenantId;
use App\Domain\User\UserId;
use App\Models\SubscriptionModel;

final readonly class SubscriptionQueryEloquent implements SubscriptionQueryInterface
{
    public function getById(SubscriptionId $id): ?Subscription
    {
        $model = SubscriptionModel::query()->whereKey($id->toString())->first();
        if (!$model) {
            return null;
        }

        return SubscriptionPersistenceMapper::toDomain($model);
    }

    public function paginate(
        PageRequest $pageRequest,
        ?TenantId $tenantId = null,
        ?UserId $createdByUserId = null,
        ?SubscriptionStatus $status = null,
    ): array {
        $page = $pageRequest->page;
        $limit = $pageRequest->limit;

        $query = SubscriptionModel::query()->orderByDesc('created_at');

        if (null !== $tenantId) {
            $query->where('tenant_id', $tenantId->toString());
        }

        if (null !== $createdByUserId) {
            $query->where('created_by_user_id', $createdByUserId->toString());
        }

        if (null !== $status) {
            $query->where('status', $status->value);
        }

        $models = $query
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get()
        ;

        return $models
            ->map(fn (SubscriptionModel $model) => SubscriptionPersistenceMapper::toDomain($model))
            ->all()
        ;
    }
}
