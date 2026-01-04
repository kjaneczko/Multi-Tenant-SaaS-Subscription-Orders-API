<?php

declare(strict_types=1);

namespace App\Domain\Subscription;

use App\Domain\Tenant\TenantId;

readonly class Subscription
{
    private function __construct(
        private SubscriptionId $id,
        private TenantId $tenantId,
        private SubscriptionPlan $plan,
        private SubscriptionInterval $interval,
        private SubscriptionStatus $status,
        private \DateTimeImmutable $currentPeriodStart,
        private \DateTimeImmutable $currentPeriodEnd,
        private ?\DateTimeImmutable $cancelledAt,
        private ?\DateTimeImmutable $createdAt,
        private ?\DateTimeImmutable $updatedAt,
    ) {}

    public static function create(
        SubscriptionId $id,
        TenantId $tenantId,
        SubscriptionPlan $plan,
        SubscriptionInterval $interval,
        SubscriptionStatus $status,
        \DateTimeImmutable $currentPeriodStart,
        \DateTimeImmutable $currentPeriodEnd,
        ?\DateTimeImmutable $cancelledAt,
        ?\DateTimeImmutable $createdAt,
        ?\DateTimeImmutable $updatedAt,
    ): self {
        return new self(
            id: $id,
            tenantId: $tenantId,
            plan: $plan,
            interval: $interval,
            status: $status,
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
        SubscriptionPlan $plan,
        SubscriptionInterval $interval,
        SubscriptionStatus $status,
        \DateTimeImmutable $currentPeriodStart,
        \DateTimeImmutable $currentPeriodEnd,
        ?\DateTimeImmutable $cancelledAt,
        ?\DateTimeImmutable $createdAt,
        ?\DateTimeImmutable $updatedAt,
    ): self {
        return new self(
            id: $id,
            tenantId: $tenantId,
            plan: $plan,
            interval: $interval,
            status: $status,
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
