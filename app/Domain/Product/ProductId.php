<?php

namespace app\Domain\Product;

readonly class ProductId
{
    public function __construct(
        private string $id,
    ) {}

    public function toString(): string
    {
        return $this->id;
    }
}
