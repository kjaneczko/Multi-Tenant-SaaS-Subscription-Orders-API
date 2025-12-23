<?php

namespace App\Domain\Subscription;

readonly class SubscriptionId
{
    public function __construct(
        private string $id,
    ) {}

    public function toString(): string
    {
        return $this->id;
    }
}
