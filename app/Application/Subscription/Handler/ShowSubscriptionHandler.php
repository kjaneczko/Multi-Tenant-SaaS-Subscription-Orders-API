<?php

declare(strict_types=1);

namespace App\Application\Subscription\Handler;

use App\Application\Subscription\Command\ShowSubscriptionCommand;
use App\Application\Subscription\Exception\SubscriptionNotFoundException;
use App\Domain\Subscription\Interface\SubscriptionQueryInterface;
use App\Domain\Subscription\Subscription;

readonly class ShowSubscriptionHandler
{
    public function __construct(
        private SubscriptionQueryInterface $query,
    ) {}

    public function __invoke(ShowSubscriptionCommand $command): Subscription
    {
        $subscription = $this->query->getById($command->subscriptionId);

        if (!$subscription) {
            throw new SubscriptionNotFoundException();
        }

        return $subscription;
    }
}
