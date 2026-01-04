<?php

declare(strict_types=1);

namespace App\Domain\Product\Interface;

use App\Application\Common\Query\PageRequest;
use App\Domain\Product\Product;
use App\Domain\Product\ProductId;
use App\Domain\Tenant\TenantId;

/**
 * Read side (CQRS-lite) – paginacja + filtrowanie.
 */
interface ProductQueryInterface
{
    public function getById(ProductId $id): ?Product;

    /**
     * @return Product[]
     */
    public function paginate(PageRequest $pageRequest, ?TenantId $tenantId = null): array;
}
