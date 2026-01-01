<?php

namespace App\Application\AuditLog\Interface;

use App\Application\AuditLog\Command\CreateAuditLogCommand;
use App\Application\AuditLog\Command\ListAuditLogCommand;
use App\Application\AuditLog\Command\ShowAuditLogCommand;
use App\Domain\AuditLog\AuditLog;

interface AuditLogServiceInterface
{
    /**
     * @return AuditLog[]
     */
    public function list(ListAuditLogCommand $command): array;

    public function create(CreateAuditLogCommand $command): void;

    public function show(ShowAuditLogCommand $command): AuditLog;
}
