<?php

declare(strict_types=1);

namespace App\Application\Order\Handler;

use App\Application\Order\Command\ListOrderCommand;
use App\Domain\Order\Interface\OrderQueryInterface;
use App\Domain\Order\Order;

readonly class ListOrderHandler
{
    public function __construct(
        private OrderQueryInterface $query,
    ) {}

    /**
     * @return Order[]
     */
    public function __invoke(ListOrderCommand $command): array
    {
        return $this->query->paginate(
            pageRequest: $command->pageRequest,
            tenantId: $command->tenantId,
        );
    }
}
