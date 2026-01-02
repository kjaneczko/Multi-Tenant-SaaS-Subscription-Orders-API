<?php

namespace App\Application\Product\Interface;

use App\Domain\Product\Product;
use App\Domain\Product\ProductId;

interface ProductRepositoryInterface
{
    public function getById(ProductId $id): Product;
    public function create(Product $product): Product;
    public function update(Product $product): bool;
    public function delete(ProductId $id): bool;
}
