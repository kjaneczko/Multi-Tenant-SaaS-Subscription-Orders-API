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
        self::assertValidAction($action);
        self::assertValidEntityType($entityType);
        self::assertValidEntityId($entityId);
        self::assertValidMeta($meta);
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
            action: trim($action),
            entityType: trim($entityType),
            entityId: trim($entityId),
            meta: $meta,
            createdAt: $createdAt,
        );
    }

    public static function reconstitute(
        AuditLogId $id,
        TenantId $tenantId,
        UserId $actorUserId,
        string $action,
        string $entityType,
        string $entityId,
        string $meta,
        ?\DateTimeImmutable $createdAt,
    ): self
    {
        self::assertValidAction($action);
        self::assertValidEntityType($entityType);
        self::assertValidEntityId($entityId);
        self::assertValidMeta($meta);

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
        self::assertValidAction($action);
        $this->action = $action;
    }

    public function changeEntityType(string $entityType): void
    {
        self::assertValidEntityType($entityType);
        $this->entityType = $entityType;
    }

    public function changeEntityId(string $entityId): void
    {
        self::assertValidEntityId($entityId);
        $this->entityId = $entityId;
    }

    public function changeMeta(string $meta): void
    {
        self::assertValidMeta($meta);
        $this->meta = $meta;
    }

    private static function assertValidAction(string $action): void
    {
        if ('' === $action) {
            throw new ValidationException(['action' => ['Action is required.']]);
        }
    }

    private static function assertValidEntityType(string $entityType): void
    {
        if ('' === $entityType) {
            throw new ValidationException(['entity_type' => ['Entity type is required.']]);
        }
    }

    private static function assertValidEntityId(string $entityId): void
    {
        if ('' === $entityId) {
            throw new ValidationException(['entity_id' => ['Entity ID is required.']]);
        }
    }

    private static function assertValidMeta(string $meta): void
    {
        if ('' === $meta) {
            throw new ValidationException(['meta' => ['Meta is required.']]);
        }

        if (!json_validate($meta)) {
            throw new ValidationException(['meta' => ['Meta is not valid JSON.']]);
        }
    }
}
