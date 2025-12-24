<?php

namespace App\Domain;

use App\Domain\Exception\ValidationException;

final readonly class Email
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim(mb_strtolower($value));

        $this->assertValidEmail($value);

        $this->value = $value;
    }

    public function toString(): string
    {
        return $this->value;
    }

    private function assertValidEmail(string $value): void
    {
        if ($value === '') {
            throw new ValidationException([
                'email' => ['Email cannot be empty.'],
            ]);
        }

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException(
                ['email' => ['Email is not valid.']],
            );
        }
    }
}
