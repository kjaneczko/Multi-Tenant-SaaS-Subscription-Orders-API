<?php

declare(strict_types=1);

namespace App\Application\OrderItem\Handler;

use App\Application\OrderItem\Command\ListOrderItemCommand;
use App\Domain\OrderItem\Interface\OrderItemQueryInterface;
use App\Domain\OrderItem\OrderItem;

readonly class ListOrderItemHandler
{
    public function __construct(
        private OrderItemQueryInterface $query,
    ) {}

    /**
     * @return OrderItem[]
     */
    public function __invoke(ListOrderItemCommand $command): array
    {
        return $this->query->paginate(
            pageRequest: $command->pageRequest,
            tenantId: $command->tenantId,
            orderId: $command->orderId,
        );
    }
}
