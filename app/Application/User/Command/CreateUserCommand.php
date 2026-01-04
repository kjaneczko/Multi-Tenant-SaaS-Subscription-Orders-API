<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Application\Common\Interface\AuditableOperation;
use App\Domain\Email;
use App\Domain\Tenant\TenantId;
use App\Domain\User\UserRole;

final readonly class CreateUserCommand
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
}
