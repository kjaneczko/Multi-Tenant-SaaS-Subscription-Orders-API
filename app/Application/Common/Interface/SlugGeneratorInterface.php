<?php

declare(strict_types=1);

namespace App\Application\Common\Interface;

use App\Domain\Slug;

interface SlugGeneratorInterface
{
    public function generate(string $value): Slug;
}
