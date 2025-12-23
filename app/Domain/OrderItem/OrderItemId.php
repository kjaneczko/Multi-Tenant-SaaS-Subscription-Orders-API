<?php

namespace App\Domain\OrderItem;

readonly class OrderItemId
{
    public function __construct(
        private string $id,
    ) {}

    public function toString(): string
    {
        return $this->id;
    }
}
