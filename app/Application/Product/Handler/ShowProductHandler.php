<?php

declare(strict_types=1);

namespace App\Application\Product\Handler;

use App\Application\Product\Command\ShowProductCommand;
use App\Application\Product\Exception\ProductNotFoundException;
use App\Domain\Product\Interface\ProductQueryInterface;
use App\Domain\Product\Product;

readonly class ShowProductHandler
{
    public function __construct(
        private ProductQueryInterface $query,
    ) {}

    public function __invoke(ShowProductCommand $command): Product
    {
        $product = $this->query->getById($command->productId);
        if (!$product) {
            throw new ProductNotFoundException();
        }
        return $product;
    }
}
