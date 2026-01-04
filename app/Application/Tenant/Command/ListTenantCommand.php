<?php

declare(strict_types=1);

namespace App\Application\Tenant\Command;

use App\Application\Common\Interface\AuditableOperation;
use App\Application\Common\Query\PageRequest;

readonly class ListTenantCommand
{
    public function __construct(
        public PageRequest $pageRequest,
    ) {}

    public function auditPayload(): array
    {
        return get_object_vars($this);
    }
}
