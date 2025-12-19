<?php

namespace app\Domain\Subscription;

use app\Domain\Tenant\TenantId;
use DateTime;

readonly class Subscription
{
    private function __construct(
        private SubscriptionId $id,
        private TenantId $tenantId,
        private string $plan,
        private string $interval,
        private string $status,
        private DateTime $currentPeriodStart,
        private DateTime $currentPeriodEnd,
        private ?DateTime $cancelledAt,
    ) {}

    public static function create(
        SubscriptionId $id,
        TenantId $tenantId,
        string $plan,
        string $interval,
        string $status,
        DateTime $currentPeriodStart,
        DateTime $currentPeriodEnd,
        ?DateTime $cancelledAt,
    ): self
    {
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

    public function plan(): string
    {
        return $this->plan;
    }

    public function interval(): string
    {
        return $this->interval;
    }

    public function status(): string
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
