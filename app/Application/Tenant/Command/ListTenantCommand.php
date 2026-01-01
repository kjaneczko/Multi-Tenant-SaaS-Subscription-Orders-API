<?php

namespace App\Application\Tenant\Command;

use App\Application\Shared\Query\PageRequest;

readonly class ListTenantCommand
{
    public function __construct(
        public PageRequest $pageRequest,
    )
    {
    }
}
