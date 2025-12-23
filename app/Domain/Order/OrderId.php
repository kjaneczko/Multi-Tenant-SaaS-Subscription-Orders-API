<?php

namespace App\Domain\Order;

readonly class OrderId
{
    public function __construct(
        private string $id,
    ) {}

    public function toString(): string
    {
        return $this->id;
    }
}
