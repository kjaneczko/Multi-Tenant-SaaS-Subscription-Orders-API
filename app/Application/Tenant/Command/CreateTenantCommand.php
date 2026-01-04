<?php

declare(strict_types=1);

namespace App\Application\Tenant\Command;

use App\Application\Common\Interface\AuditableOperation;

readonly class CreateTenantCommand
{
    public function __construct(
        public string $name,
    ) {}

    public function auditPayload(): array
    {
        return get_object_vars($this);
    }
}
