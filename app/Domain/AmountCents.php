<?php

namespace App\Domain;

final readonly class AmountCents
{
    private int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function toInt(): int
    {
        return $this->value;
    }

    public function isNegative(): bool
    {
        return $this->value < 0;
    }

    public function isZero(): bool
    {
        return $this->value === 0;
    }

    public function isPositive(): bool
    {
        return $this->value > 0;
    }

    public function add(self $other): self
    {
        return new self($this->value + $other->value);
    }

    public function sub(self $other): self
    {
        return new self($this->value - $other->value);
    }
}
