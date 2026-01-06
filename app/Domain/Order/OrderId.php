<?php

declare(strict_types=1);

namespace App\Domain\Order;

use App\Domain\Exception\ValidationException;

readonly class OrderId
{
    public function __construct(public string $value)
    {
        $value = trim($value);
        if ('' === $value) {
            throw new ValidationException(['id' => ['OrderId cannot be empty.']]);
        }
    }

    public function toString(): string
    {
        return $this->value;
    }
}
