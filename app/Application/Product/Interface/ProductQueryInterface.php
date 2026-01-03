<?php

namespace App\Application\Product\Interface;

use App\Application\Shared\Query\PageRequest;
use App\Domain\Product\Product;

/**
 * Read side (CQRS-lite) – paginacja + filtrowanie.
 */
interface ProductQueryInterface
{
    /**
     * @return Product[]
     */
    public function paginate(PageRequest $pageRequest, ?string $tenantId = null): array;
}
