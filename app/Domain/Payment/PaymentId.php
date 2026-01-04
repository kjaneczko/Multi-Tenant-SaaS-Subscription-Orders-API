<?php

declare(strict_types=1);

namespace App\Domain\Payment;

use App\Domain\Exception\ValidationException;

final readonly class PaymentId
{
    public function __construct(private string $value)
    {
        if ('' === $value) {
            throw new ValidationException(['id' => ['PaymentId cannot be empty.']]);
        }
    }

    public function toString(): string
    {
        return $this->value;
    }
}
