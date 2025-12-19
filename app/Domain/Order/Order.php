<?php

namespace app\Domain\Order;

use app\Domain\Tenant\TenantId;
use app\Domain\User\UserId;
use DateTime;

readonly class Order
{
    private function __construct(
        private OrderId $id,
        private TenantId $tenantId,
        private UserId $createdByUserId,
        private string $customerEmail,
        private string $status,
        private string $currency,
        private int $subtotalCents,
        private int $discountCents,
        private int $taxCents,
        private int $totalCents,
        private ?string $notes,
        private ?DateTime $paidAt,
        private ?DateTime $cancelledAt,
        private ?DateTime $deletedAt,
    ) {}

    public static function create(
        OrderId $id,
        TenantId $tenantId,
        UserId $createdByUserId,
        string $customerEmail,
        string $status,
        string $currency,
        int $subtotalCents,
        int $discountCents,
        int $taxCents,
        int $totalCents,
        ?string $notes,
        ?DateTime $paidAt,
        ?DateTime $cancelledAt,
        ?DateTime $deletedAt,
    ): self
    {
        return new self(
            id: $id,
            tenantId: $tenantId,
            createdByUserId: $createdByUserId,
            customerEmail: $customerEmail,
            status: $status,
            currency: $currency,
            subtotalCents: $subtotalCents,
            discountCents: $discountCents,
            taxCents: $taxCents,
            totalCents: $totalCents,
            notes: $notes,
            paidAt: $paidAt,
            cancelledAt: $cancelledAt,
            deletedAt: $deletedAt,
        );
    }

    public function id(): OrderId
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

    public function customerEmail(): string
    {
        return $this->customerEmail;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function subtotalCents(): int
    {
        return $this->subtotalCents;
    }

    public function discountCents(): int
    {
        return $this->discountCents;
    }

    public function taxCents(): int
    {
        return $this->taxCents;
    }

    public function totalCents(): int
    {
        return $this->totalCents;
    }

    public function notes(): string
    {
        return $this->notes;
    }

    public function paidAt(): ?DateTime
    {
        return $this->paidAt;
    }

    public function cancelledAt(): ?DateTime
    {
        return $this->cancelledAt;
    }

    public function deletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }
}
