<?php

declare(strict_types=1);

namespace App\Domain\AuditLog;

readonly class AuditLogId
{
    public function __construct(
        private string $id,
    ) {}

    public function toString(): string
    {
        return $this->id;
    }
}
