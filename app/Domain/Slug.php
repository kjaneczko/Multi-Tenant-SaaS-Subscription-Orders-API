<?php

namespace App\Domain;

use App\Domain\Exception\ValidationException;

final readonly class Slug
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim(mb_strtolower($value));

        self::assertValidSlug($value);

        $this->value = $value;
    }

    public function toString(): string
    {
        return $this->value;
    }

    private static function assertValidSlug(string $value): void
    {
        $length = mb_strlen($value);

        if ($length < 3) {
            throw new ValidationException(['slug' => ['Slug is too short. Must be at least 3 characters.']]);
        }

        if ($length > 255) {
            throw new ValidationException(['slug' => ['Slug is too long. Must be less than 256 characters.']]);
        }

        // a-z0-9 and single hyphens between segments
        if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $value)) {
            throw new ValidationException(['slug' => ['Slug has invalid format. Use a-z, 0-9 and hyphens.']]);
        }
    }
}
