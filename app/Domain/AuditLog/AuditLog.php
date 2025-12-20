<?php

namespace app\Domain\AuditLog;

use app\Domain\Tenant\TenantId;
use app\Domain\User\UserId;

readonly class AuditLog
{
    private function __construct(
        private AuditLogId $id,
        private TenantId $tenantId,
        private UserId $actorUserId,
        private string $action,
        private string $entityType,
        private string $entityId,
        private string $meta,
    ) {}

    public static function create(
        AuditLogId $id,
        TenantId $tenantId,
        UserId $actorUserId,
        string $action,
        string $entityType,
        string $entityId,
        string $meta,
    ): self {
        return new self(
            id: $id,
            tenantId: $tenantId,
            actorUserId: $actorUserId,
            action: $action,
            entityType: $entityType,
            entityId: $entityId,
            meta: $meta,
        );
    }

    public function id(): AuditLogId
    {
        return $this->id;
    }

    public function tenantId(): TenantId
    {
        return $this->tenantId;
    }

    public function actorUserId(): UserId
    {
        return $this->actorUserId;
    }

    public function action(): string
    {
        return $this->action;
    }

    public function entityType(): string
    {
        return $this->entityType;
    }

    public function entityId(): string
    {
        return $this->entityId;
    }

    public function meta(): string
    {
        return $this->meta;
    }
}
