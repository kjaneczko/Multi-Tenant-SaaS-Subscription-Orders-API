<?php

namespace App\Domain\AuditLog;

use App\Domain\Exception\ValidationException;
use App\Domain\JsonString;
use App\Domain\Tenant\TenantId;
use App\Domain\User\UserId;

readonly class AuditLog
{
    /**
     * @param AuditLogId $id
     * @param TenantId $tenantId
     * @param UserId $actorUserId
     * @param string $action - "<entity>.<verb>" e.g. order.paid, order.status_changed, product.created
     * @param EntityType $entityType
     * @param string $entityId
     * @param JsonString $meta
     * @param \DateTimeImmutable $createdAt
     */
    private function __construct(
        private AuditLogId $id,
        private TenantId $tenantId,
        private UserId $actorUserId,
        private string $action,
        private EntityType $entityType,
        private string $entityId,
        private JsonString $meta,
        private \DateTimeImmutable $createdAt,
    ) {
        $this->assertValidAction($action);
        $this->assertValidEntityId($entityId);
    }

    public static function create(
        AuditLogId $id,
        TenantId $tenantId,
        UserId $actorUserId,
        string $action,
        EntityType $entityType,
        string $entityId,
        JsonString $meta,
        \DateTimeImmutable $createdAt,
    ): self {
        return new self(
            id: $id,
            tenantId: $tenantId,
            actorUserId: $actorUserId,
            action: trim($action),
            entityType: $entityType,
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
        EntityType $entityType,
        string $entityId,
        JsonString $meta,
        \DateTimeImmutable $createdAt,
    ): self
    {
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

    public function entityType(): EntityType
    {
        return $this->entityType;
    }

    public function entityId(): string
    {
        return $this->entityId;
    }

    public function meta(): JsonString
    {
        return $this->meta;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    private function assertValidAction(string $action): void
    {
        if ('' === $action) {
            throw new ValidationException(['action' => ['Action is required.']]);
        }
    }

    private function assertValidEntityId(string $entityId): void
    {
        if ('' === $entityId) {
            throw new ValidationException(['entity_id' => ['Entity ID is required.']]);
        }
    }
}
