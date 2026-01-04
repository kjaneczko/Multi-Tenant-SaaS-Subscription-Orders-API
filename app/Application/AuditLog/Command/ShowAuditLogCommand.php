<?php

declare(strict_types=1);

namespace App\Application\AuditLog\Command;

use App\Application\Common\AuditCategory;
use App\Application\Common\Interface\AuditableOperation;
use App\Domain\AuditLog\AuditLogId;
use App\Domain\EntityType;

readonly class ShowAuditLogCommand implements AuditableOperation
{
    public function __construct(
        public AuditLogId $auditLogId,
    ) {}

    public function auditCategory(): AuditCategory
    {
        return AuditCategory::ACCESS;
    }

    public function auditAction(): string
    {
        return EntityType::AUDIT_LOG->value.'.show';
    }

    public function auditEntityType(): ?EntityType
    {
        return EntityType::AUDIT_LOG;
    }

    public function auditEntityId(): ?string
    {
        return $this->auditLogId->toString();
    }

    public function auditPayload(): array
    {
        return get_object_vars($this);
    }
}
