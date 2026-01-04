<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Payment;

use App\Application\Common\Query\PageRequest;
use App\Domain\Payment\Interface\PaymentQueryInterface;
use App\Domain\Payment\PaymentEntityType;
use App\Models\PaymentModel;

final readonly class PaymentQueryEloquent implements PaymentQueryInterface
{
    public function paginate(
        PageRequest $pageRequest,
        ?string $tenantId = null,
        ?PaymentEntityType $entityType = null,
    ): array {
        // Jeżeli PageRequest ma gettery, zamień na:
        // $page = $pageRequest->page();
        // $limit = $pageRequest->limit();
        $page = $pageRequest->page;
        $limit = $pageRequest->limit;

        $query = PaymentModel::query()
            ->orderByDesc('created_at')
        ;

        if (null !== $tenantId && '' !== $tenantId) {
            $query->where('tenant_id', $tenantId);
        }

        if (null !== $entityType) {
            $query->where('entity_type', $entityType->value);
        }

        $models = $query
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get()
        ;

        return $models
            ->map(fn (PaymentModel $model) => PaymentPersistenceMapper::toDomain($model))
            ->all()
        ;
    }
}
