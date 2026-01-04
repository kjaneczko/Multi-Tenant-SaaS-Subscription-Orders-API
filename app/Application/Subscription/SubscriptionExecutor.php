<?php

declare(strict_types=1);

namespace App\Application\Subscription;

use App\Domain\Subscription\Subscription;
use App\Domain\Subscription\SubscriptionId;

/**
 * Todo-style executor.
 *
 * NOTE: Subscription module is not yet wired with a repository interface in this codebase.
 * This executor is intentionally written to be dropped in once you add a SubscriptionRepositoryInterface
 * (recommended location: App\Domain\Subscription\Interface\SubscriptionRepositoryInterface).
 *
 * Expected repository methods:
 *  - getById(SubscriptionId $id): Subscription
 *  - update(Subscription $subscription): bool
 *  - delete(SubscriptionId $id): bool
 */
readonly class SubscriptionExecutor
{
    public function __construct(
        private object $repository,
    ) {}

    public function getOrFail(SubscriptionId $id): Subscription
    {
        try {
            /** @var Subscription $subscription */
            return $this->repository->getById($id);
        } catch (\Throwable $e) {
            throw new \RuntimeException('Subscription not found.', previous: $e);
        }
    }

    public function updateOrFail(Subscription $subscription): void
    {
        if (!$this->repository->update($subscription)) {
            throw new \RuntimeException('Subscription not found.');
        }
    }

    public function deleteOrFail(SubscriptionId $id): void
    {
        if (!$this->repository->delete($id)) {
            throw new \RuntimeException('Subscription not found.');
        }
    }
}
