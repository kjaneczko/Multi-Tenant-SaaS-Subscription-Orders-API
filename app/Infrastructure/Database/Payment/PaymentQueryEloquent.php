<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Payment;

use App\Application\Common\Query\PageRequest;
use App\Domain\Payment\Interface\PaymentQueryInterface;
use App\Domain\Payment\Payment;
use App\Domain\Payment\PaymentEntityType;
use App\Domain\Payment\PaymentId;
use App\Domain\Tenant\TenantId;
use App\Models\PaymentModel;

final readonly class PaymentQueryEloquent implements PaymentQueryInterface
{
    public function getById(PaymentId $id): ?Payment
    {
        $model = PaymentModel::query()->find($id->toString());

        if (!$model) {
            return null;
        }

        return PaymentPersistenceMapper::toDomain($model);
    }

    public function paginate(
        PageRequest $pageRequest,
        ?TenantId $tenantId = null,
        ?PaymentEntityType $entityType = null,
    ): array {
        $page = $pageRequest->page;
        $limit = $pageRequest->limit;

        $query = PaymentModel::query()
            ->orderByDesc('created_at');

        if (null !== $tenantId) {
            $query->where('tenant_id', $tenantId->toString());
        }

        if (null !== $entityType) {
            $query->where('entity_type', $entityType->value);
        }

        $models = $query
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get();

        return $models
            ->map(fn (PaymentModel $model) => PaymentPersistenceMapper::toDomain($model))
            ->all();
    }
}
