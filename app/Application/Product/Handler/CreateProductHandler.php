<?php

namespace App\Application\Product\Handler;

use App\Application\Product\Command\CreateProductCommand;
use App\Application\Product\Interface\ProductRepositoryInterface;
use App\Application\Shared\Interface\UuidGeneratorInterface;
use App\Domain\Product\Product;
use App\Domain\Product\ProductId;
use App\Domain\Product\ProductStatus;

final readonly class CreateProductHandler
{
    public function __construct(
        private ProductRepositoryInterface $products,
        private UuidGeneratorInterface     $uuid,
    ) {}

    public function __invoke(CreateProductCommand $command): ProductId
    {
        $now = new \DateTimeImmutable();

        $id = new ProductId($this->uuid->generate());
        $product = Product::create(
            id: $id,
            tenantId: $command->tenantId,
            sku: $command->sku,
            name: $command->name,
            slug: $command->slug,
            description: $command->description,
            priceCents: $command->priceCents,
            currency: $command->currency,
            status: ProductStatus::INACTIVE,
            createdAt: $now,
            updatedAt: $now,
        );

        $this->products->create($product);

        return $id;
    }
}
