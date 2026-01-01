<?php

namespace App\Infrastructure\Database\AuditLog;

use App\Domain\AuditLog\AuditLog;
use App\Domain\AuditLog\Interface\AuditLogWriterInterface;
use App\Infrastructure\Database\Exception\DatabaseException;
use App\Models\AuditLogModel;
use Illuminate\Database\QueryException;

class AuditLogWriterEloquent implements AuditLogWriterInterface
{
    public function create(AuditLog $auditLog): void
    {
        try {
            $model = AuditLogModel::create(AuditLogPersistenceMapper::toPersistence($auditLog));
        }
        catch (QueryException $e) {
            throw DatabaseException::failedToSave($e);
        }

        if (!$model) {
            throw DatabaseException::failedToSave();
        }
    }
}
