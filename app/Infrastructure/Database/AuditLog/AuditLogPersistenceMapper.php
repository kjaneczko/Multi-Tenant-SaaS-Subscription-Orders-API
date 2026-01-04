<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\AuditLog;

use App\Application\Common\AuditCategory;
use App\Domain\AuditLog\AuditLog;
use App\Domain\AuditLog\AuditLogId;
use App\Domain\EntityType;
use App\Domain\PayloadJsonString;
use App\Domain\Tenant\TenantId;
use App\Domain\User\UserId;
use App\Models\AuditLogModel;

final readonly class AuditLogPersistenceMapper
{
    public static function toDomain(AuditLogModel $auditLog): AuditLog
    {
        return AuditLog::reconstitute(
            id: new AuditLogId($auditLog->id),
            tenantId: new TenantId($auditLog->tenant_id),
            actorUserId: new UserId($auditLog->actor_user_id),
            category: AuditCategory::from($auditLog->category),
            action: $auditLog->action,
            entityType: EntityType::from($auditLog->entity_type),
            entityId: $auditLog->entity_id,
            payload: new PayloadJsonString($auditLog->payload),
            durationMs: $auditLog->duration_ms,
            success: $auditLog->success,
            errorType: $auditLog->error_type,
            errorMessage: $auditLog->error_message,
            requestId: $auditLog->request_id,
            ip: $auditLog->ip,
            userAgent: $auditLog->user_agent,
            createdAt: new \DateTimeImmutable($auditLog->created_at),
        );
    }

    public static function toPersistence(AuditLog $auditLog): array
    {
        return [
            'id' => $auditLog->id()->toString(),
            'tenant_id' => $auditLog->tenantId()->toString(),
            'actor_user_id' => $auditLog->actorUserId()->toString(),
            'category' => $auditLog->category()->value,
            'action' => $auditLog->action(),
            'entity_type' => $auditLog->entityType(),
            'entity_id' => $auditLog->entityId(),
            'payload' => $auditLog->payload()->toString(),
            'duration_ms' => $auditLog->durationMs(),
            'success' => $auditLog->success(),
            'error_type' => $auditLog->errorType(),
            'error_message' => $auditLog->errorMessage(),
            'request_id' => $auditLog->requestId(),
            'ip' => $auditLog->ip(),
            'user_agent' => $auditLog->userAgent(),
            'created_at' => $auditLog->createdAt()->format('Y-m-d H:i:s'),
        ];
    }
}
