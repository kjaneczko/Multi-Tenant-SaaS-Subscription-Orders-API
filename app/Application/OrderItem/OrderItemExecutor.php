<?php

declare(strict_types=1);

namespace App\Application\OrderItem;

use App\Domain\OrderItem\OrderItem;
use App\Domain\OrderItem\OrderItemId;

/**
 * Todo-style executor.
 *
 * NOTE: OrderItem module is not yet wired with a repository interface in this codebase.
 * This executor is intentionally written to be dropped in once you add an OrderItemRepositoryInterface
 * (recommended location: App\Domain\OrderItem\Interface\OrderItemRepositoryInterface).
 *
 * Expected repository methods:
 *  - getById(OrderItemId $id): OrderItem
 *  - update(OrderItem $item): bool
 *  - delete(OrderItemId $id): bool
 */
readonly class OrderItemExecutor
{
    public function __construct(
        private object $repository,
    ) {}

    public function getByIdOrFail(OrderItemId $id): OrderItem
    {
        try {
            /** @var OrderItem $item */
            return $this->repository->getById($id);
        } catch (\Throwable $e) {
            throw new \RuntimeException('Order item not found.', previous: $e);
        }
    }

    public function updateOrFail(OrderItem $item): void
    {
        if (!$this->repository->update($item)) {
            throw new \RuntimeException('Order item not found.');
        }
    }

    public function deleteOrFail(OrderItemId $id): void
    {
        if (!$this->repository->delete($id)) {
            throw new \RuntimeException('Order item not found.');
        }
    }
}
