<?php

declare(strict_types=1);

namespace App\Domain\AuditLog\Interface;

use App\Domain\AuditLog\AuditLog;
use App\Domain\AuditLog\AuditLogId;

interface AuditLogWriterInterface
{
    public function write(AuditLog $auditLog): void;
}
