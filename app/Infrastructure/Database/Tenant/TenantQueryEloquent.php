<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Tenant;

use App\Application\Common\Query\PageRequest;
use App\Domain\Tenant\Interface\TenantQueryInterface;
use App\Domain\Tenant\Tenant;
use App\Domain\Tenant\TenantId;
use App\Models\TenantModel;

final readonly class TenantQueryEloquent implements TenantQueryInterface
{
    public function getById(TenantId $id): ?Tenant
    {
        $model = TenantModel::find($id->toString());
        if (!$model) {
            return null;
        }

        return TenantPersistenceMapper::toDomain($model);
    }

    public function paginate(PageRequest $pageRequest, ?string $tenantId = null): array
    {
        $page = $pageRequest->page;
        $limit = $pageRequest->limit;

        $query = TenantModel::query()->orderByDesc('created_at');

        if (null !== $tenantId && '' !== $tenantId) {
            $query->where('tenant_id', $tenantId);
        }

        $models = $query
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get()
        ;

        return $models
            ->map(fn (TenantModel $model) => TenantPersistenceMapper::toDomain($model))
            ->all()
        ;
    }
}
