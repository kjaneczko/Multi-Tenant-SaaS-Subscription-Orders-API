<?php

namespace App\Domain;

readonly class MetaJsonString extends JsonString
{
    public function __construct(string $value)
    {
        parent::__construct($value, 'meta', 'Meta');
    }
}
