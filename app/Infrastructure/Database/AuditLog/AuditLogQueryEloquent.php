<?php

namespace App\Infrastructure\Database\AuditLog;

use App\Application\AuditLog\Exception\AuditLogNotFoundException;
use App\Application\Shared\Query\PageRequest;
use App\Domain\AuditLog\AuditLog;
use App\Domain\AuditLog\AuditLogId;
use App\Domain\AuditLog\Interface\AuditLogQueryInterface;
use App\Models\AuditLogModel;

class AuditLogQueryEloquent implements AuditLogQueryInterface
{

    public function findByIdOrFail(AuditLogId $auditLogId): AuditLog
    {
        $model = AuditLogModel::find($auditLogId->toString());
        if (!$model) {
            throw new AuditLogNotFoundException();
        }
        return AuditLogPersistenceMapper::toDomain($model);
    }

    public function findAll(PageRequest $pageRequest): array
    {
        $offset = ($pageRequest->page - 1) * $pageRequest->limit;

        $query = AuditLogModel::skip($offset)
            ->take($pageRequest->limit)
            ->orderBy('entity_type');

        return $query->get()
            ->map(fn (AuditLogModel $model) => AuditLogPersistenceMapper::toDomain($model))
            ->all();
    }
}
