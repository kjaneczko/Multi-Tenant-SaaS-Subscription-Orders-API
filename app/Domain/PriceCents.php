<?php

namespace App\Domain;

use App\Domain\Exception\ValidationException;

final readonly class PriceCents
{
    private int $value;

    public function __construct(int $value)
    {
        self::assertValidValue($value);
        $this->value = $value;
    }

    public function toInt(): int
    {
        return $this->value;
    }

    public function toAmount(): AmountCents
    {
        return new AmountCents($this->value);
    }

    private static function assertValidValue(int $value): void
    {
        if ($value <= 0) {
            throw new ValidationException(['price' => ['Price cannot be negative.']]);
        }
    }
}
