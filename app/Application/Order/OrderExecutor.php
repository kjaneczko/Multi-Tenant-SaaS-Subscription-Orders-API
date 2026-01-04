<?php

declare(strict_types=1);

namespace App\Application\Order;

use App\Domain\Order\Order;
use App\Domain\Order\OrderId;

/**
 * Todo-style executor.
 *
 * NOTE: Order module is not yet wired with a repository interface in this codebase.
 * This executor is intentionally written to be dropped in once you add an OrderRepositoryInterface
 * (recommended location: App\Domain\Order\Interface\OrderRepositoryInterface).
 *
 * Expected repository methods:
 *  - getById(OrderId $id): Order
 *  - update(Order $order): bool
 *  - delete(OrderId $id): bool
 */
readonly class OrderExecutor
{
    public function __construct(
        private object $repository,
    ) {}

    public function getByIdOrFail(OrderId $id): Order
    {
        try {
            /** @var Order $order */
            return $this->repository->getById($id);
        } catch (\Throwable $e) {
            throw new \RuntimeException('Order not found.', previous: $e);
        }
    }

    public function updateOrFail(Order $order): void
    {
        if (!$this->repository->update($order)) {
            throw new \RuntimeException('Order not found.');
        }
    }

    public function deleteOrFail(OrderId $id): void
    {
        if (!$this->repository->delete($id)) {
            throw new \RuntimeException('Order not found.');
        }
    }
}
