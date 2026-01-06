<?php

declare(strict_types=1);

namespace App\Application\Subscription\Command;

use App\Application\Common\AuditCategory;
use App\Application\Common\Interface\AuditableOperation;
use App\Domain\Currency;
use App\Domain\EntityType;
use App\Domain\PriceCents;
use App\Domain\Subscription\SubscriptionInterval;
use App\Domain\Subscription\SubscriptionPlan;
use App\Domain\Subscription\SubscriptionStatus;
use App\Domain\Tenant\TenantId;
use App\Domain\User\UserId;

final readonly class CreateSubscriptionCommand implements AuditableOperation
{
    public function __construct(
        public TenantId $tenantId,
        public ?UserId $createdByUserId,
        public SubscriptionStatus $status,
        public Currency $currency,
        public PriceCents $priceCents,
        public SubscriptionPlan $plan,
        public SubscriptionInterval $interval,
        public \DateTimeImmutable $startedAt,
        public ?\DateTimeImmutable $endedAt,
        public \DateTimeImmutable $currentPeriodStart,
        public \DateTimeImmutable $currentPeriodEnd,
        public ?\DateTimeImmutable $cancelledAt,
    ) {}

    public function auditPayload(): array
    {
        return get_object_vars($this);
    }

    public function auditCategory(): AuditCategory
    {
        return AuditCategory::AUDIT;
    }

    public function auditAction(): string
    {
        return EntityType::SUBSCRIPTION->value.'.create';
    }

    public function auditEntityType(): ?EntityType
    {
        return EntityType::SUBSCRIPTION;
    }

    public function auditEntityId(): ?string
    {
        return null;
    }
}
