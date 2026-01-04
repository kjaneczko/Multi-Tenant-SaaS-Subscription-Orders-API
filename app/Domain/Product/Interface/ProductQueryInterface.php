<?php

declare(strict_types=1);

namespace App\Domain\Product\Interface;

use App\Application\Common\Query\PageRequest;
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
