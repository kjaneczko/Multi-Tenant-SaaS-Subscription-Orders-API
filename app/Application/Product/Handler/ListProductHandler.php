<?php

declare(strict_types=1);

namespace App\Application\Product\Handler;

use App\Application\Product\Command\ListProductCommand;
use App\Domain\Product\Interface\ProductQueryInterface;
use App\Domain\Product\Product;

readonly class ListProductHandler
{
    public function __construct(
        private ProductQueryInterface $query,
    ) {}

    /**
     * @return Product[]
     */
    public function __invoke(ListProductCommand $command): array
    {
        return $this->query->paginate(
            pageRequest: $command->pageRequest,
            tenantId: $command->tenantId,
        );
    }
}
