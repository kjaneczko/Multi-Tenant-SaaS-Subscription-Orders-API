<?php

namespace App\Infrastructure;

use App\Application\Shared\Interface\UuidGeneratorInterface;
use Illuminate\Support\Str;

class UuidGenerator implements UuidGeneratorInterface
{

    public function generate(): string
    {
        return Str::uuid()->toString();
    }
}
