<?php

declare(strict_types=1);

namespace App\Application\AuditLog\Handler;

use App\Application\AuditLog\Command\ShowAuditLogCommand;
use App\Application\AuditLog\Exception\AuditLogNotFoundException;
use App\Domain\AuditLog\AuditLog;
use App\Domain\AuditLog\Interface\AuditLogQueryInterface;

readonly class ShowAuditLogHandler
{
    public function __construct(
        private AuditLogQueryInterface $query,
    ) {}

    public function __invoke(ShowAuditLogCommand $command): AuditLog
    {
        $auditLog = $this->query->getById($command->auditLogId);
        if (!$auditLog) {
            throw new AuditLogNotFoundException();
        }
        return $auditLog;
    }
}
