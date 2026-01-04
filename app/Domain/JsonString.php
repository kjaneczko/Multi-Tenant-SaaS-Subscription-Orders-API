<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Exception\ValidationException;

readonly class JsonString
{
    public function __construct(
        private string $value,
        protected string $keyValue = 'json',
        protected string $fieldValue = 'Json',
    ) {
        $this->assertValidJson($this->value);
    }

    public function toString(): string
    {
        return $this->value;
    }

    private function assertValidJson(string $value): void
    {
        if (!json_validate($value)) {
            throw new ValidationException([$this->keyValue => [sprintf('%s is not valid JSON.', $this->fieldValue)]]);
        }
    }
}
