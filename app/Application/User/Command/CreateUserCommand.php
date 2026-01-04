<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Application\Common\AuditCategory;
use App\Application\Common\Interface\AuditableOperation;
use App\Domain\Email;
use App\Domain\EntityType;
use App\Domain\Tenant\TenantId;
use App\Domain\User\UserRole;

final readonly class CreateUserCommand implements AuditableOperation
{
    public function __construct(
        public TenantId $tenantId,
        public string $name,
        public Email $email,
        public string $password,
        public UserRole $role,
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
        return EntityType::USER->value.'.create';
    }

    public function auditEntityType(): ?EntityType
    {
        return EntityType::USER;
    }

    public function auditEntityId(): ?string
    {
        return null;
    }
}
