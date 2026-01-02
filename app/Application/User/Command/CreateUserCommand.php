<?php

namespace App\Application\User\Command;

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
}
