<?php

declare(strict_types=1);

namespace App\Application\AuditLog\Command;

use App\Application\Common\AuditCategory;
use App\Application\Common\Interface\AuditableOperation;
use App\Application\Common\Query\PageRequest;
use App\Domain\EntityType;

readonly class ListAuditLogCommand implements AuditableOperation
{
    public function __construct(
        public PageRequest $pageRequest,
    ) {}

    public function auditCategory(): AuditCategory
    {
        return AuditCategory::ACCESS;
    }

    public function auditAction(): string
    {
        return EntityType::AUDIT_LOG->value.'.list';
    }

    public function auditEntityType(): ?EntityType
    {
        return EntityType::AUDIT_LOG;
    }

    public function auditEntityId(): ?string
    {
        return null;
    }

    public function auditPayload(): array
    {
        return get_object_vars($this);
    }
}
