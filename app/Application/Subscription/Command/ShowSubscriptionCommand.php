<?php

declare(strict_types=1);

namespace App\Application\Subscription\Command;

use App\Application\Common\AuditCategory;
use App\Application\Common\Interface\AuditableOperation;
use App\Domain\EntityType;
use App\Domain\Subscription\SubscriptionId;

readonly class ShowSubscriptionCommand implements AuditableOperation
{
    public function __construct(
        public SubscriptionId $subscriptionId,
    ) {}

    public function auditCategory(): AuditCategory
    {
        return AuditCategory::AUDIT;
    }

    public function auditAction(): string
    {
        return EntityType::SUBSCRIPTION->value.'.show';
    }

    public function auditEntityType(): ?EntityType
    {
        return EntityType::SUBSCRIPTION;
    }

    public function auditEntityId(): ?string
    {
        return $this->subscriptionId->toString();
    }

    public function auditPayload(): array
    {
        return get_object_vars($this);
    }
}
