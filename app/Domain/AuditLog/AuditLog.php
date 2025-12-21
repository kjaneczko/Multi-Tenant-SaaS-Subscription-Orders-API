<?php

namespace app\Domain\AuditLog;

use app\Domain\Exception\ValidationException;
use app\Domain\Tenant\TenantId;
use app\Domain\User\UserId;

class AuditLog
{
    private function __construct(
        private readonly AuditLogId $id,
        private readonly TenantId $tenantId,
        private readonly UserId $actorUserId,
        private string $action,
        private string $entityType,
        private string $entityId,
        private string $meta,
        private readonly ?\DateTimeImmutable $createdAt,
    ) {
        $this->assertValidAction($action);
        $this->assertValidEntityType($entityType);
        $this->assertValidEntityId($entityId);
        $this->assertValidMeta($meta);
    }

    public static function create(
        AuditLogId $id,
        TenantId $tenantId,
        UserId $actorUserId,
        string $action,
        string $entityType,
        string $entityId,
        string $meta,
        ?\DateTimeImmutable $createdAt,
    ): self {
        return new self(
            id: $id,
            tenantId: $tenantId,
            actorUserId: $actorUserId,
            action: $action,
            entityType: $entityType,
            entityId: $entityId,
            meta: $meta,
            createdAt: $createdAt,
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

    public function createdAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function changeAction(string $action): void
    {
        $this->assertValidAction($action);
        $this->action = $action;
    }

    public function changeEntityType(string $entityType): void
    {
        $this->assertValidEntityType($entityType);
        $this->entityType = $entityType;
    }

    public function changeEntityId(string $entityId): void
    {
        $this->assertValidEntityId($entityId);
        $this->entityId = $entityId;
    }

    public function changeMeta(string $meta): void
    {
        $this->assertValidMeta($meta);
        $this->meta = $meta;
    }

    private function assertValidAction(string $action): void
    {
        if ('' === $action) {
            throw new ValidationException(['action' => ['Action is required.']]);
        }
    }

    private function assertValidEntityType(string $entityType): void
    {
        if ('' === $entityType) {
            throw new ValidationException(['entity_type' => ['Entity type is required.']]);
        }
    }

    private function assertValidEntityId(string $entityId): void
    {
        if ('' === $entityId) {
            throw new ValidationException(['entity_id' => ['Entity ID is required.']]);
        }
    }

    private function assertValidMeta(string $meta): void
    {
        if ('' === $meta) {
            throw new ValidationException(['meta' => ['Meta is required.']]);
        }

        if (!json_validate($meta)) {
            throw new ValidationException(['meta' => ['Meta is not valid JSON.']]);
        }
    }
}
