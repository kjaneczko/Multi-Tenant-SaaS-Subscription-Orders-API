<?php

declare(strict_types=1);

namespace App\Application\Tenant\Command;

use App\Application\Common\Interface\AuditableOperation;
use App\Domain\Tenant\TenantId;

readonly class ShowTenantCommand implements AuditableOperation
{
    public function __construct(
        public TenantId $id,
    ) {}

    public function auditPayload(): array
    {
        return get_object_vars($this);
    }
}
