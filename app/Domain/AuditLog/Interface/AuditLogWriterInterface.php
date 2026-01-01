<?php

namespace App\Domain\AuditLog\Interface;

use App\Domain\AuditLog\AuditLog;

interface AuditLogWriterInterface
{
    public function create(AuditLog $auditLog): void;
}
