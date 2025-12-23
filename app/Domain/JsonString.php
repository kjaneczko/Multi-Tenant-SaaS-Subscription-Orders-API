<?php

namespace App\Domain;

final readonly class JsonString
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function toString(): string
    {
        return $this->value;
    }

    private static function assertValidJson(string $value): void
    {

    }
}
