<?php

declare(strict_types=1);

namespace App\Domain\Subscription;

use App\Domain\Exception\ValidationException;

final readonly class SubscriptionId
{
    public function __construct(public string $value)
    {
        $value = trim($value);
        if ('' === $value) {
            throw new ValidationException(['id' => ['SubscriptionId cannot be empty.']]);
        }
    }

    public function toString(): string
    {
        return $this->value;
    }
}
