<?php

declare(strict_types=1);

namespace App\Application\Product\Handler;

use App\Application\Product\Command\CreateProductCommand;
use App\Application\Product\ProductExecutor;
use App\Application\Common\Interface\UuidGeneratorInterface;
use App\Domain\Product\Product;
use App\Domain\Product\ProductId;
use App\Domain\Product\ProductStatus;

final readonly class CreateProductHandler
{
    public function __construct(
        private ProductExecutor $executor,
        private UuidGeneratorInterface $uuid,
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

        $this->executor->create($product);

        return $id;
    }
}
