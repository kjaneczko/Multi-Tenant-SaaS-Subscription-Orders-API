<?php

namespace App\Application\AuditLog\Handler;

use App\Application\AuditLog\Command\ListAuditLogCommand;
use App\Domain\AuditLog\AuditLog;
use App\Domain\AuditLog\Interface\AuditLogQueryInterface;

readonly class ListAuditLogHandler
{
    public function __construct(
        private AuditLogQueryInterface $auditLogQuery,
    )
    {
    }

    /**
     * @return AuditLog[]
     */
    public function __invoke(ListAuditLogCommand $command): array
    {
        return $this->auditLogQuery->findAll(
            pageRequest: $command->pageRequest,
        );
    }
}
