<?php

namespace App\Application\AuditLog\Handler;

use App\Application\AuditLog\Command\CreateAuditLogCommand;
use App\Application\Shared\Interface\UuidGeneratorInterface;
use App\Domain\AuditLog\AuditLog;
use App\Domain\AuditLog\AuditLogId;
use App\Domain\AuditLog\Interface\AuditLogWriterInterface;

readonly class CreateAuditLogHandler
{
    public function __construct(
        private AuditLogWriterInterface $auditLogWriter,
        private UuidGeneratorInterface  $uuid,
    ) {}

    public function __invoke(
        CreateAuditLogCommand $command,
    ): AuditLog
    {
        $auditLog = AuditLog::create(
            id: new AuditLogId($this->uuid->generate()),
            tenantId: $command->tenantId,
            actorUserId: $command->actorUserId,
            action: $command->action,
            entityType: $command->entityType,
            entityId: $command->entityId,
            meta: $command->meta,
            createdAt: new \DateTimeImmutable(),
        );

        $this->auditLogWriter->create($auditLog);

        return $auditLog;
    }
}
