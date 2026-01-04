<?php

declare(strict_types=1);

namespace App\Domain\AuditLog\Interface;

use App\Domain\AuditLog\AuditLog;

interface AuditLogWriterInterface
{
    public function write(AuditLog $auditLog): void;
}
