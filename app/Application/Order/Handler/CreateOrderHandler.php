<?php

declare(strict_types=1);

namespace App\Application\Order\Handler;

use App\Application\Common\Interface\UuidGeneratorInterface;
use App\Application\Order\Command\CreateOrderCommand;
use App\Domain\Order\Interface\OrderRepositoryInterface;
use App\Domain\Order\Order;
use App\Domain\Order\OrderId;
use App\Domain\Order\OrderStatus;

final readonly class CreateOrderHandler
{
    public function __construct(
        private OrderRepositoryInterface $repository,
        private UuidGeneratorInterface $uuid,
    ) {}

    public function __invoke(CreateOrderCommand $command): Order
    {
        $now = new \DateTimeImmutable();

        $order = Order::create(
            id: new OrderId($this->uuid->generate()),
            tenantId: $command->tenantId,
            createdByUserId: $command->createdByUserId,
            customerEmail: $command->customerEmail,
            status: OrderStatus::from($command->status),
            currency: $command->currency,
            subtotalCents: $command->subtotalCents,
            discountCents: $command->discountCents,
            taxCents: $command->taxCents,
            notes: $command->notes,
            paidAt: $command->paidAt,
            refundedAt: $command->refundedAt,
            cancelledAt: $command->cancelledAt,
            deliveredAt: null,
            createdAt: $now,
            updatedAt: $now,
        );

        return $this->repository->create($order);
    }
}
