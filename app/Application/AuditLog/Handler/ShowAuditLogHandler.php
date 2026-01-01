<?php

namespace App\Application\AuditLog\Handler;

use App\Application\AuditLog\Command\ShowAuditLogCommand;
use App\Domain\AuditLog\AuditLog;
use App\Domain\AuditLog\Interface\AuditLogQueryInterface;

readonly class ShowAuditLogHandler
{

    public function __construct(
        private AuditLogQueryInterface $auditLogQuery,
    )
    {
    }

    public function __invoke(ShowAuditLogCommand $command): AuditLog
    {
        return $this->auditLogQuery->findByIdOrFail($command->auditLogId);
    }
}
