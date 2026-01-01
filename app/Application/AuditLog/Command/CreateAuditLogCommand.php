<?php

namespace App\Application\AuditLog\Command;

use App\Domain\AuditLog\EntityType;
use App\Domain\MetaJsonString;
use App\Domain\Tenant\TenantId;
use App\Domain\User\UserId;

readonly class CreateAuditLogCommand
{
    public function __construct(
        public TenantId $tenantId,
        public UserId $actorUserId,
        public string $action,
        public EntityType $entityType,
        public string $entityId,
        public MetaJsonString $meta,
    ) {}
}
