<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Application\Common\Interface\PasswordHashGeneratorInterface;
use Illuminate\Support\Facades\Hash;

class PasswordHashGenerator implements PasswordHashGeneratorInterface
{
    public function generate(string $value): string
    {
        return Hash::make($value);
    }
}
