<?php

declare(strict_types=1);

namespace App\Domain\AuditLog\Interface;

use App\Application\Common\Query\PageRequest;
use App\Domain\AuditLog\AuditLog;
use App\Domain\AuditLog\AuditLogId;

interface AuditLogQueryInterface
{
    public function getById(AuditLogId $auditLogId): ?AuditLog;

    /**
     * @return AuditLog[]
     */
    public function list(PageRequest $pageRequest): array;
}
