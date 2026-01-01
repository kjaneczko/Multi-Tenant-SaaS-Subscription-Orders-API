<?php

namespace App\Infrastructure\Database\AuditLog;

use App\Domain\AuditLog\AuditLog;
use App\Domain\AuditLog\AuditLogId;
use App\Domain\AuditLog\EntityType;
use App\Domain\MetaJsonString;
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
            action: $auditLog->action,
            entityType: EntityType::from($auditLog->entity_type),
            entityId: $auditLog->entity_id,
            meta: new MetaJsonString($auditLog->meta),
            createdAt: new \DateTimeImmutable($auditLog->created_at),
        );
    }

    public static function toPersistence(AuditLog $auditLog): array
    {
        return [
            'id' => $auditLog->id()->toString(),
            'tenant_id' => $auditLog->tenantId()->toString(),
            'actor_user_id' => $auditLog->actorUserId()->toString(),
            'action' => $auditLog->action(),
            'entity_type' => $auditLog->entityType(),
            'entity_id' => $auditLog->entityId(),
            'meta' => $auditLog->meta()->toString(),
            'created_at' => $auditLog->createdAt()->format('Y-m-d H:i:s'),
        ];
    }
}
