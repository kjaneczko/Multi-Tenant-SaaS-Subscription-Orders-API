<?php

namespace App\Infrastructure\Database\Payment;

use App\Application\Payment\Interface\PaymentQueryInterface;
use App\Application\Shared\Query\PageRequest;
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
            ->orderByDesc('created_at');

        if ($tenantId !== null && $tenantId !== '') {
            $query->where('tenant_id', $tenantId);
        }

        if ($entityType !== null) {
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
