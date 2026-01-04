<?php

declare(strict_types=1);

namespace App\Application\Product;

use App\Application\Product\Command\CreateProductCommand;
use App\Application\Product\Handler\CreateProductHandler;
use App\Application\Product\Interface\ProductServiceInterface;
use App\Application\Common\Query\PageRequest;
use App\Domain\Product\Interface\ProductRepositoryInterface;
use App\Domain\Product\Product;
use App\Domain\Product\ProductId;

final readonly class ProductService implements ProductServiceInterface
{
    public function __construct(
        private CreateProductCommand       $createProductCommand,
        private ProductExecutor            $executor,
        private ProductRepositoryInterface $productRepository,
        private CreateProductHandler       $createProductHandler,
    ) {}

    public function create(CreateProductCommand $command): Product
    {
        $id = ($this->createProductHandler)($command);

        return $this->executor->getByIdOrFail(new ProductId($id->toString()));
    }

    public function getById(PaymentId $id): Payment
    {
        return $this->executor->getByIdOrFail($id);
    }

    public function paginate(
        PageRequest $pageRequest,
        ?string $tenantId = null,
        ?PaymentEntityType $entityType = null,
    ): array {
        return $this->paymentQuery->paginate(
            pageRequest: $pageRequest,
            tenantId: $tenantId,
            entityType: $entityType,
        );
    }
}
