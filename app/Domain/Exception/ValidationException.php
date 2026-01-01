<?php

namespace App\Domain\Exception;

class ValidationException extends \DomainException
{
    private array $errors;

    public function __construct(array $errors)
    {
        $this->errors = $errors;
        parent::__construct('Validation failed.');
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
