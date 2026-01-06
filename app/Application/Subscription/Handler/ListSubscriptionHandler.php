<?php

declare(strict_types=1);

namespace App\Application\Subscription\Handler;

use App\Application\Subscription\Command\ListSubscriptionCommand;
use App\Domain\Subscription\Interface\SubscriptionQueryInterface;
use App\Domain\Subscription\Subscription;

readonly class ListSubscriptionHandler
{
    public function __construct(
        private SubscriptionQueryInterface $query,
    ) {}

    /**
     * @return Subscription[]
     */
    public function __invoke(ListSubscriptionCommand $command): array
    {
        return $this->query->paginate(
            pageRequest: $command->pageRequest,
            tenantId: $command->tenantId,
            createdByUserId: $command->createdByUserId,
            status: $command->status,
        );
    }
}
