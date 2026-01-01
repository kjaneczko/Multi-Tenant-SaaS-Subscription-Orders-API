<?php

namespace App\Application\Tenant\Command;

readonly class CreateTenantCommand
{
    public function __construct(
        public string $name,
    )
    {
    }
}
