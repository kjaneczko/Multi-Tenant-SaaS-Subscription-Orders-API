<?php

declare(strict_types=1);

namespace App\Domain;

readonly class PayloadJsonString extends JsonString
{
    public function __construct(string $value)
    {
        parent::__construct($value, 'payload', 'Payload');
    }
}
