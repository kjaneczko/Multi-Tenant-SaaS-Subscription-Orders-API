<?php

namespace App\Infrastructure;

use App\Application\Shared\Interface\PasswordHashGeneratorInterface;
use Illuminate\Support\Facades\Hash;

class PasswordHashGenerator implements PasswordHashGeneratorInterface
{

    public function generate(string $value): string
    {
        return Hash::make($value);
    }
}
