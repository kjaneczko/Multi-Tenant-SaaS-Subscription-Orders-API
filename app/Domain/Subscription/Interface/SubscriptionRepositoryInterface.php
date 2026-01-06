<?php

declare(strict_types=1);

namespace App\Domain\Subscription\Interface;

use App\Domain\Subscription\Subscription;
use App\Domain\Subscription\SubscriptionId;

interface SubscriptionRepositoryInterface
{
    public function create(Subscription $subscription): Subscription;

    public function update(Subscription $subscription): bool;

    public function delete(SubscriptionId $id): bool;
}
