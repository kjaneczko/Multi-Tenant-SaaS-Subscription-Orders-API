<?php

namespace App\Domain\AuditLog\Interface;

use App\Application\Shared\Query\PageRequest;
use App\Domain\AuditLog\AuditLog;
use App\Domain\AuditLog\AuditLogId;

interface AuditLogQueryInterface
{
    public function findByIdOrFail(AuditLogId $auditLogId): AuditLog;

    /**
     * @return AuditLog[]
     */
    public function findAll(PageRequest $pageRequest): array;
}
