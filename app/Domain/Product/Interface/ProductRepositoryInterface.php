<?php

declare(strict_types=1);

namespace App\Domain\Product\Interface;

use App\Domain\Product\Product;
use App\Domain\Product\ProductId;

interface ProductRepositoryInterface
{
    public function create(Product $product): Product;

    public function update(Product $product): bool;

    public function delete(ProductId $id): bool;
}
