<?php

declare(strict_types=1);

namespace App\Domain\Order\Interface;

use App\Application\Common\Query\PageRequest;
use App\Domain\Order\Order;
use App\Domain\Order\OrderId;
use App\Domain\Tenant\TenantId;

/**
 * Read side (CQRS-lite) – paginacja + filtrowanie.
 */
interface OrderQueryInterface
{
    public function getById(OrderId $id): ?Order;

    /**
     * @return Order[]
     */
    public function paginate(PageRequest $pageRequest, ?TenantId $tenantId = null): array;
}
