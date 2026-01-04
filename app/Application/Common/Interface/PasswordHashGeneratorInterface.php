<?php

declare(strict_types=1);

namespace App\Application\Common\Interface;

interface PasswordHashGeneratorInterface
{
    public function generate(string $value): string;
}
