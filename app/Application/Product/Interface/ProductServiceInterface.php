<?php

declare(strict_types=1);

namespace App\Application\Product\Interface;

use App\Application\Product\Command\CreateProductCommand;
use App\Application\Common\Query\PageRequest;
use App\Domain\Product\Product;
use App\Domain\Product\ProductId;

interface ProductServiceInterface
{
    public function create(CreateProductCommand $command): Product;

    public function getById(ProductId $id): Product;

    /**
     * @return Product[]
     */
    public function paginate(PageRequest $pageRequest): array;
}
