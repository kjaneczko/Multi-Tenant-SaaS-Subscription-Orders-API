<?php

declare(strict_types=1);

namespace App\Domain\Subscription;

use App\Domain\Currency;
use App\Domain\PriceCents;
use App\Domain\Tenant\TenantId;
use App\Domain\User\UserId;

readonly class Subscription
{
    private function __construct(
        private SubscriptionId $id,
        private TenantId $tenantId,
        private UserId $createdByUserId,
        private SubscriptionPlan $plan,
        private SubscriptionInterval $interval,
        private SubscriptionStatus $status,
        private Currency $currency,
        private PriceCents $priceCents,
        private \DateTimeImmutable $startedAt,
        private ?\DateTimeImmutable $endedAt,
        private \DateTimeImmutable $currentPeriodStart,
        private \DateTimeImmutable $currentPeriodEnd,
        private ?\DateTimeImmutable $cancelledAt,
        private ?\DateTimeImmutable $createdAt,
        private ?\DateTimeImmutable $updatedAt,
    ) {}

    public static function create(
        SubscriptionId $id,
        TenantId $tenantId,
        UserId $createdByUserId,
        SubscriptionPlan $plan,
        SubscriptionInterval $interval,
        SubscriptionStatus $status,
        Currency $currency,
        PriceCents $priceCents,
        \DateTimeImmutable $startedAt,
        ?\DateTimeImmutable $endedAt,
        \DateTimeImmutable $currentPeriodStart,
        \DateTimeImmutable $currentPeriodEnd,
        ?\DateTimeImmutable $cancelledAt,
        ?\DateTimeImmutable $createdAt,
        ?\DateTimeImmutable $updatedAt,
    ): self {
        return new self(
            id: $id,
            tenantId: $tenantId,
            createdByUserId: $createdByUserId,
            plan: $plan,
            interval: $interval,
            status: $status,
            currency: $currency,
            priceCents: $priceCents,
            startedAt: $startedAt,
            endedAt: $endedAt,
            currentPeriodStart: $currentPeriodStart,
            currentPeriodEnd: $currentPeriodEnd,
            cancelledAt: $cancelledAt,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
        );
    }

    public static function reconstitute(
        SubscriptionId $id,
        TenantId $tenantId,
        UserId $createdByUserId,
        SubscriptionPlan $plan,
        SubscriptionInterval $interval,
        SubscriptionStatus $status,
        Currency $currency,
        PriceCents $priceCents,
        \DateTimeImmutable $startedAt,
        ?\DateTimeImmutable $endedAt,
        \DateTimeImmutable $currentPeriodStart,
        \DateTimeImmutable $currentPeriodEnd,
        ?\DateTimeImmutable $cancelledAt,
        ?\DateTimeImmutable $createdAt,
        ?\DateTimeImmutable $updatedAt,
    ): self {
        return new self(
            id: $id,
            tenantId: $tenantId,
            createdByUserId: $createdByUserId,
            plan: $plan,
            interval: $interval,
            status: $status,
            currency: $currency,
            priceCents: $priceCents,
            startedAt: $startedAt,
            endedAt: $endedAt,
            currentPeriodStart: $currentPeriodStart,
            currentPeriodEnd: $currentPeriodEnd,
            cancelledAt: $cancelledAt,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
        );
    }

    public function id(): SubscriptionId
    {
        return $this->id;
    }

    public function tenantId(): TenantId
    {
        return $this->tenantId;
    }

    public function createdByUserId(): UserId
    {
        return $this->createdByUserId;
    }

    public function plan(): SubscriptionPlan
    {
        return $this->plan;
    }

    public function interval(): SubscriptionInterval
    {
        return $this->interval;
    }

    public function status(): SubscriptionStatus
    {
        return $this->status;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }

    public function priceCents(): PriceCents
    {
        return $this->priceCents;
    }

    public function startedAt(): \DateTimeImmutable
    {
        return $this->startedAt;
    }

    public function endedAt(): ?\DateTimeImmutable
    {
        return $this->endedAt;
    }

    public function currentPeriodStart(): \DateTimeImmutable
    {
        return $this->currentPeriodStart;
    }

    public function currentPeriodEnd(): \DateTimeImmutable
    {
        return $this->currentPeriodEnd;
    }

    public function cancelledAt(): ?\DateTimeImmutable
    {
        return $this->cancelledAt;
    }

    public function createdAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
