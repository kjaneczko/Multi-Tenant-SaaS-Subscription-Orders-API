<?php

declare(strict_types=1);

namespace App\Domain\OrderItem;

use App\Domain\Exception\ValidationException;

final readonly class OrderItemId
{
    public function __construct(public string $value)
    {
        $value = trim($value);
        if ('' === $value) {
            throw new ValidationException(['id' => ['OrderItemId cannot be empty.']]);
        }
    }

    public function toString(): string
    {
        return $this->value;
    }
}
