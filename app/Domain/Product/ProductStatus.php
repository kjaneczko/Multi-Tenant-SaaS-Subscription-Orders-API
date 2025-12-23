<?php

namespace App\Domain\Product;

enum ProductStatus: string
{
    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';
}
