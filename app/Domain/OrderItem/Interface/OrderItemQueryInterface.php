<?php

declare(strict_types=1);

namespace App\Domain\OrderItem\Interface;

use App\Application\Common\Query\PageRequest;
use App\Domain\OrderItem\OrderItem;
use App\Domain\OrderItem\OrderItemId;
use App\Domain\Tenant\TenantId;

interface OrderItemQueryInterface
{
    public function getById(OrderItemId $id): ?OrderItem;

    /**
     * @return OrderItem[]
     */
    public function paginate(PageRequest $pageRequest, ?TenantId $tenantId = null, ?string $orderId = null): array;
}
