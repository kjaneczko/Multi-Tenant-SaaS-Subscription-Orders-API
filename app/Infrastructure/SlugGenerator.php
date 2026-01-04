<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Application\Common\Interface\SlugGeneratorInterface;
use App\Domain\Slug;
use Illuminate\Support\Str;

readonly class SlugGenerator implements SlugGeneratorInterface
{
    public function generate(string $value): Slug
    {
        return new Slug(Str::slug($value));
    }
}
