<?php

declare(strict_types=1);

namespace App\Domain\Product;

use App\Domain\Exception\ValidationException;

final readonly class ProductId
{
    public function __construct(public string $value)
    {
        $value = trim($value);
        if ('' === $value) {
            throw new ValidationException(['id' => ['ProductId cannot be empty.']]);
        }
    }

    public function toString(): string
    {
        return $this->value;
    }
}
