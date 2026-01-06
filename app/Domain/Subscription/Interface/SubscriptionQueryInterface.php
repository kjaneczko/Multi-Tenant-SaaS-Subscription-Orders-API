<?php

declare(strict_types=1);

namespace App\Domain\Subscription\Interface;

use App\Application\Common\Query\PageRequest;
use App\Domain\Subscription\Subscription;
use App\Domain\Subscription\SubscriptionId;
use App\Domain\Subscription\SubscriptionStatus;
use App\Domain\Tenant\TenantId;
use App\Domain\User\UserId;

interface SubscriptionQueryInterface
{
    public function getById(SubscriptionId $id): ?Subscription;

    /**
     * @return Subscription[]
     */
    public function paginate(
        PageRequest $pageRequest,
        ?TenantId $tenantId = null,
        ?UserId $createdByUserId = null,
        ?SubscriptionStatus $status = null,
    ): array;
}
