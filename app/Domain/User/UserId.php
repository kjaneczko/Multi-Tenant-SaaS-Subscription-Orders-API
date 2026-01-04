<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Exception\ValidationException;

readonly class UserId
{
    public function __construct(
        private string $id,
    ) {
        $value = trim($id);
        if ('' === $value) {
            throw new ValidationException(['id' => ['UserId cannot be empty.']]);
        }
    }

    public function toString(): string
    {
        return $this->id;
    }
}
