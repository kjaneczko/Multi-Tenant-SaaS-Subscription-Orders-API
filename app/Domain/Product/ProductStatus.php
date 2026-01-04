<?php

declare(strict_types=1);

namespace App\Domain\Product;

enum ProductStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
