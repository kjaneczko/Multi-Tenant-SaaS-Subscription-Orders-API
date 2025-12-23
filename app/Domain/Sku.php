<?php

namespace App\Domain;

use App\Domain\Exception\ValidationException;

final readonly class Sku
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim(mb_strtoupper($value));

        self::assertValidSku($value);

        $this->value = $value;
    }

    public function toString(): string
    {
        return $this->value;
    }

    private static function assertValidSku(string $sku): void
    {
        if (mb_strlen($sku) < 3) {
            throw new ValidationException(['sku' => ['Sku is too short. Must be at least 3 characters.']]);
        }

        if (mb_strlen($sku) > 64) {
            throw new ValidationException(['sku' => ['Sku is too long. Must be less than 64 characters.']]);
        }

        // A-Z, 0-9, dash/underscore; no spaces; no separators at ends
        if (!preg_match('/^[A-Z0-9](?:[A-Z0-9\-_]*[A-Z0-9])?$/', $sku)) {
            throw new ValidationException(['sku' => ['Sku has invalid format. Use A-Z, 0-9, "-" and "_" only.']]);
        }
    }
}
