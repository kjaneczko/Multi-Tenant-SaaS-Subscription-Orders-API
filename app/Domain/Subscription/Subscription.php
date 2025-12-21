<?php

namespace app\Domain\Subscription;

use app\Domain\Tenant\TenantId;
use DateTime;

readonly class Subscription
{
    private function __construct(
        private SubscriptionId $id,
        private TenantId       $tenantId,
        private SubscriptionPlan         $plan,
        private SubscriptionInterval         $interval,
        private SubscriptionStatus         $status,
        private DateTime       $currentPeriodStart,
        private DateTime       $currentPeriodEnd,
        private ?DateTime      $cancelledAt,
    ) {}

    public static function create(
        SubscriptionId $id,
        TenantId       $tenantId,
        SubscriptionPlan         $plan,
        SubscriptionInterval         $interval,
        SubscriptionStatus         $status,
        DateTime       $currentPeriodStart,
        DateTime       $currentPeriodEnd,
        ?DateTime      $cancelledAt,
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

    public function currentPeriodStart(): DateTime
    {
        return $this->currentPeriodStart;
    }

    public function currentPeriodEnd(): DateTime
    {
        return $this->currentPeriodEnd;
    }

    public function cancelledAt(): ?DateTime
    {
        return $this->cancelledAt;
    }
}
