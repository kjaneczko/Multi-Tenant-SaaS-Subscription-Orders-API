<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Application\Common\AuditCategory;
use App\Application\Common\Interface\AuditableOperation;
use App\Application\Common\Query\PageRequest;
use App\Domain\EntityType;
use App\Domain\Tenant\TenantId;
use App\Domain\User\UserRole;

readonly class ListUserCommand implements AuditableOperation
{
    public function __construct(
        public PageRequest $pageRequest,
        public ?TenantId $tenantId,
        public ?UserRole $role,
        public ?bool $isActive,
    ) {}

    public function auditCategory(): AuditCategory
    {
        return AuditCategory::ACCESS;
    }

    public function auditAction(): string
    {
        return EntityType::USER->value.'.list';
    }

    public function auditEntityType(): ?EntityType
    {
        return EntityType::USER;
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
