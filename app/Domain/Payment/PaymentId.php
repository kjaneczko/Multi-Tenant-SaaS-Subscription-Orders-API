<?php

namespace app\Domain\Payment;

readonly class PaymentId
{
    public function __construct(
        private string $id,
    ) {}

    public function toString(): string
    {
        return $this->id;
    }
}
