<?php

declare(strict_types=1);

namespace App\Application\OrderItem\Handler;

use App\Application\OrderItem\Command\ShowOrderItemCommand;
use App\Application\OrderItem\Exception\OrderItemNotFoundException;
use App\Domain\OrderItem\Interface\OrderItemQueryInterface;
use App\Domain\OrderItem\OrderItem;

readonly class ShowOrderItemHandler
{
    public function __construct(
        private OrderItemQueryInterface $query,
    ) {}

    public function __invoke(ShowOrderItemCommand $command): OrderItem
    {
        $orderItem = $this->query->getById($command->orderItemId);

        if (!$orderItem) {
            throw new OrderItemNotFoundException();
        }

        return $orderItem;
    }
}
