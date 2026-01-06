<?php

declare(strict_types=1);

namespace App\Application\OrderItem\Handler;

use App\Application\Common\Interface\UuidGeneratorInterface;
use App\Application\OrderItem\Command\CreateOrderItemCommand;
use App\Domain\OrderItem\Interface\OrderItemRepositoryInterface;
use App\Domain\OrderItem\OrderItem;
use App\Domain\OrderItem\OrderItemId;

final readonly class CreateOrderItemHandler
{
    public function __construct(
        private OrderItemRepositoryInterface $repository,
        private UuidGeneratorInterface $uuid,
    ) {}

    public function __invoke(CreateOrderItemCommand $command): OrderItem
    {
        $now = new \DateTimeImmutable();

        $orderItem = OrderItem::create(
            id: new OrderItemId($this->uuid->generate()),
            tenantId: $command->tenantId,
            orderId: $command->orderId,
            productId: $command->productId,
            productNameSnapshot: $command->productNameSnapshot,
            skuSnapshot: $command->skuSnapshot,
            quantity: $command->quantity,
            unitPriceCents: $command->unitPriceCents,
            createdAt: $now,
            updatedAt: $now,
        );

        return $this->repository->create($orderItem);
    }
}
