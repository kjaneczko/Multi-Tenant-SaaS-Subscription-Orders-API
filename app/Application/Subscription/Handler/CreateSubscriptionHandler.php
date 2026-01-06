<?php

declare(strict_types=1);

namespace App\Application\Subscription\Handler;

use App\Application\Common\Interface\UuidGeneratorInterface;
use App\Application\Subscription\Command\CreateSubscriptionCommand;
use App\Domain\Subscription\Interface\SubscriptionRepositoryInterface;
use App\Domain\Subscription\Subscription;
use App\Domain\Subscription\SubscriptionId;

final readonly class CreateSubscriptionHandler
{
    public function __construct(
        private SubscriptionRepositoryInterface $repository,
        private UuidGeneratorInterface $uuid,
    ) {}

    public function __invoke(CreateSubscriptionCommand $command): Subscription
    {
        $now = new \DateTimeImmutable();

        $subscription = Subscription::create(
            id: new SubscriptionId($this->uuid->generate()),
            tenantId: $command->tenantId,
            createdByUserId: $command->createdByUserId,
            plan: $command->plan,
            interval: $command->interval,
            status: $command->status,
            currency: $command->currency,
            priceCents: $command->priceCents,
            startedAt: $command->startedAt,
            endedAt: $command->endedAt,
            currentPeriodStart: $command->currentPeriodStart,
            currentPeriodEnd: $command->currentPeriodEnd,
            cancelledAt: $command->cancelledAt,
            createdAt: $now,
            updatedAt: $now,
        );

        return $this->repository->create($subscription);
    }
}
