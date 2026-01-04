<?php

declare(strict_types=1);

namespace App\Application\Common\Interface;

interface UuidGeneratorInterface
{
    public function generate(): string;
}
