<?php

namespace App\Application\AuditLog\Command;

use App\Application\Shared\Query\PageRequest;

readonly class ListAuditLogCommand
{
    public function __construct(
        public PageRequest $pageRequest,
    )
    {
    }
}
