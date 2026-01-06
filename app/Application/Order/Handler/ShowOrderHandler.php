<?php

declare(strict_types=1);

namespace App\Application\Order\Handler;

use App\Application\Order\Command\ShowOrderCommand;
use App\Application\Order\Exception\OrderNotFoundException;
use App\Domain\Order\Interface\OrderQueryInterface;
use App\Domain\Order\Order;

readonly class ShowOrderHandler
{
    public function __construct(
        private OrderQueryInterface $query,
    ) {}

    public function __invoke(ShowOrderCommand $command): Order
    {
        $order = $this->query->getById($command->orderId);
        if (!$order) {
            throw new OrderNotFoundException();
        }

        return $order;
    }
}
