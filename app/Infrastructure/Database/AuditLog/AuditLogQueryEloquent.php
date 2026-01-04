<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\AuditLog;

use App\Application\Common\Query\PageRequest;
use App\Domain\AuditLog\AuditLog;
use App\Domain\AuditLog\AuditLogId;
use App\Domain\AuditLog\Interface\AuditLogQueryInterface;
use App\Models\AuditLogModel;

class AuditLogQueryEloquent implements AuditLogQueryInterface
{
    public function getById(AuditLogId $auditLogId): ?AuditLog
    {
        $model = AuditLogModel::find($auditLogId->toString());
        if (!$model) {
            return null;
        }

        return AuditLogPersistenceMapper::toDomain($model);
    }

    public function paginate(PageRequest $pageRequest): array
    {
        $page = $pageRequest->page;
        $limit = $pageRequest->limit;

        $offset = ($page - 1) * $limit;
        $query = AuditLogModel::skip($offset)
            ->take($limit)
            ->orderBy('entity_type')
        ;

        return $query->get()
            ->map(fn (AuditLogModel $model) => AuditLogPersistenceMapper::toDomain($model))
            ->all()
        ;
    }
}
