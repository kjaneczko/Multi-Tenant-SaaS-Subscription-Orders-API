<?php

declare(strict_types=1);

namespace App\Application\Tenant\Command;

use App\Application\Common\AuditCategory;
use App\Application\Common\Interface\AuditableOperation;
use App\Domain\EntityType;

readonly class CreateTenantCommand implements AuditableOperation
{
    public function __construct(
        public string $name,
    ) {}

    public function auditPayload(): array
    {
        return get_object_vars($this);
    }

    public function auditCategory(): AuditCategory
    {
        return AuditCategory::AUDIT;
    }

    public function auditAction(): string
    {
        return EntityType::TENANT->value.'.create';
    }

    public function auditEntityType(): ?EntityType
    {
        return EntityType::TENANT;
    }

    public function auditEntityId(): ?string
    {
        return null;
    }
}
