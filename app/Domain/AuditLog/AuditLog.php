<?php

declare(strict_types=1);

namespace App\Domain\AuditLog;

use App\Application\Common\AuditCategory;
use App\Domain\EntityType;
use App\Domain\Exception\ValidationException;
use App\Domain\PayloadJsonString;
use App\Domain\Tenant\TenantId;
use App\Domain\User\UserId;

readonly class AuditLog
{
    /**
     * @param string $action - "<entity>.<verb>" e.g. order.paid, order.status_changed, product.created
     */
    private function __construct(
        private AuditLogId $id,
        private TenantId $tenantId,
        private UserId $actorUserId,
        private AuditCategory $category,
        private string $action,
        private EntityType $entityType,
        private ?string $entityId,
        private PayloadJsonString $payload,
        private int $durationMs,
        private bool $success,
        private ?string $errorType,
        private ?string $errorMessage,
        private string $requestId,
        private string $ip,
        private string $userAgent,
        private \DateTimeImmutable $createdAt,
    ) {
        $this->assertValidAction($action);
    }

    public static function create(
        AuditLogId $id,
        TenantId $tenantId,
        UserId $actorUserId,
        AuditCategory $category,
        string $action,
        EntityType $entityType,
        ?string $entityId,
        PayloadJsonString $payload,
        int $durationMs,
        bool $success,
        ?string $errorType,
        ?string $errorMessage,
        string $requestId,
        string $ip,
        string $userAgent,
        \DateTimeImmutable $createdAt,
    ): self {
        return new self(
            id: $id,
            tenantId: $tenantId,
            actorUserId: $actorUserId,
            category: $category,
            action: trim($action),
            entityType: $entityType,
            entityId: $entityId ? trim($entityId) : null,
            payload: $payload,
            durationMs: $durationMs,
            success: $success,
            errorType: $errorType,
            errorMessage: $errorMessage,
            requestId: $requestId,
            ip: $ip,
            userAgent: $userAgent,
            createdAt: $createdAt,
        );
    }

    public static function reconstitute(
        AuditLogId $id,
        TenantId $tenantId,
        UserId $actorUserId,
        AuditCategory $category,
        string $action,
        EntityType $entityType,
        ?string $entityId,
        PayloadJsonString $payload,
        int $durationMs,
        bool $success,
        ?string $errorType,
        ?string $errorMessage,
        string $requestId,
        string $ip,
        string $userAgent,
        \DateTimeImmutable $createdAt,
    ): self {
        return new self(
            id: $id,
            tenantId: $tenantId,
            actorUserId: $actorUserId,
            category: $category,
            action: $action,
            entityType: $entityType,
            entityId: $entityId,
            payload: $payload,
            durationMs: $durationMs,
            success: $success,
            errorType: $errorType,
            errorMessage: $errorMessage,
            requestId: $requestId,
            ip: $ip,
            userAgent: $userAgent,
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

    public function category(): AuditCategory
    {
        return $this->category;
    }

    public function action(): string
    {
        return $this->action;
    }

    public function entityType(): EntityType
    {
        return $this->entityType;
    }

    public function entityId(): ?string
    {
        return $this->entityId;
    }

    public function payload(): PayloadJsonString
    {
        return $this->payload;
    }

    public function durationMs(): int
    {
        return $this->durationMs;
    }

    public function success(): bool
    {
        return $this->success;
    }

    public function errorType(): ?string
    {
        return $this->errorType;
    }

    public function errorMessage(): ?string
    {
        return $this->errorMessage;
    }

    public function requestId(): string
    {
        return $this->requestId;
    }

    public function ip(): string
    {
        return $this->ip;
    }

    public function userAgent(): string
    {
        return $this->userAgent;
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
}
