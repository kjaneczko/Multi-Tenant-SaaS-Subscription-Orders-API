<?php

namespace App\Domain\Tenant;

readonly class TenantId
{
    public function __construct(
        private string $id,
    ) {}

    public function toString(): string
    {
        return $this->id;
    }
}
