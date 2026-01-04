<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Application\Common\Interface\UuidGeneratorInterface;
use Illuminate\Support\Str;

class UuidGenerator implements UuidGeneratorInterface
{
    public function generate(): string
    {
        return Str::uuid()->toString();
    }
}
