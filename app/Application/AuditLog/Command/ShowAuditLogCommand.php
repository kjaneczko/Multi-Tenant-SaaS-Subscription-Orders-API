<?php

namespace App\Application\AuditLog\Command;

use App\Domain\AuditLog\AuditLogId;

readonly class ShowAuditLogCommand
{
    public function __construct(
        public AuditLogId $auditLogId,
    )
    {
    }
}
