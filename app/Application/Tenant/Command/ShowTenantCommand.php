<?php

namespace App\Application\Tenant\Command;

use App\Domain\Tenant\TenantId;

readonly class ShowTenantCommand
{
    public function __construct(
        public TenantId $id,
    )
    {
    }
}
