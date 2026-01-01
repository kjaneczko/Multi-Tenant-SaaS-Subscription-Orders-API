<?php

namespace App\Application\Shared\Interface;

use App\Domain\Slug;

interface SlugGeneratorInterface
{
    public function generate(string $value): Slug;
}
