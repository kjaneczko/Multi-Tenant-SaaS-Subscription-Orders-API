<?php

namespace App\Domain;

use App\Domain\Exception\ValidationException;

class JsonString
{
    protected string $keyValue = 'json';
    protected string $fieldValue = 'Json';

    private string $value;

    public function __construct(string $value)
    {
        $this->assertValidJson($value);
        $this->value = $value;
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
