<?php

declare(strict_types=1);

namespace App\Application\Product;

use App\Application\Product\Exception\ProductNotFoundException;
use App\Domain\Product\Interface\ProductRepositoryInterface;
use App\Domain\Product\Product;
use App\Domain\Product\ProductId;

readonly class ProductExecutor
{
    public function __construct(
        private ProductRepositoryInterface $repository,
    ) {}

    public function getByIdOrFail(ProductId $id): Product
    {
        $product = $this->repository->getById($id);
        if (!$product) {
            throw new ProductNotFoundException();
        }

        return $product;
    }

    public function create(Product $product): void
    {
        $this->repository->create($product);
    }

    public function updateOrFail(Product $product): void
    {
        if (!$this->repository->update($product)) {
            throw new ProductNotFoundException();
        }
    }

    public function deleteOrFail(ProductId $id): void
    {
        if (!$this->repository->delete($id)) {
            throw new ProductNotFoundException();
        }
    }
}
