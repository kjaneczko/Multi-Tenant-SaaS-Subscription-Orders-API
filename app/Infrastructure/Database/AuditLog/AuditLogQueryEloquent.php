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

    public function list(PageRequest $pageRequest): array
    {
        $offset = ($pageRequest->page - 1) * $pageRequest->limit;

        $query = AuditLogModel::skip($offset)
            ->take($pageRequest->limit)
            ->orderBy('entity_type')
        ;

        return $query->get()
            ->map(fn (AuditLogModel $model) => AuditLogPersistenceMapper::toDomain($model))
            ->all()
        ;
    }
}
