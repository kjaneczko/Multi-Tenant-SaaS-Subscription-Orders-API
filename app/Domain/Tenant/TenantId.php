<?php

declare(strict_types=1);

namespace App\Domain\Tenant;

use App\Domain\Exception\ValidationException;

readonly class TenantId
{
    public function __construct(
        private string $id,
    ) {
        $value = trim($id);
        if ('' === $value) {
            throw new ValidationException(['id' => ['TenantId cannot be empty.']]);
        }
    }

    public function toString(): string
    {
        return $this->id;
    }
}
