<?php

namespace App\Application\Shared\Interface;

interface PasswordHashGeneratorInterface
{
    public function generate(string $value): string;
}
