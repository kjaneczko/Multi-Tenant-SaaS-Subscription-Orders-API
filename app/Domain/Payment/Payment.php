<?php

namespace app\Domain\Payment;

use app\Domain\Order\OrderId;
use app\Domain\Tenant\TenantId;

readonly class Payment
{
    private function __construct(
        private PaymentId $id,
        private TenantId $tenantId,
        private OrderId $orderId,
        private PaymentStatus $status,
        private string $provider,
        private ?string $reference,
        private int $amountCents,
        private string $currency,
        private \DateTime $paidAd,
    ) {}

    public static function create(
        PaymentId $id,
        TenantId $tenantId,
        OrderId $orderId,
        PaymentStatus $status,
        string $provider,
        ?string $reference,
        int $amountCents,
        string $sku,
        \DateTime $paidAd,
    ): self {
        return new self(
            id: $id,
            tenantId: $tenantId,
            orderId: $orderId,
            status: $status,
            provider: $provider,
            reference: $reference,
            amountCents: $amountCents,
            currency: $sku,
            paidAd: $paidAd,
        );
    }

    public function id(): PaymentId
    {
        return $this->id;
    }

    public function tenantId(): TenantId
    {
        return $this->tenantId;
    }

    public function orderId(): OrderId
    {
        return $this->orderId;
    }

    public function status(): PaymentStatus
    {
        return $this->status;
    }

    public function provider(): string
    {
        return $this->provider;
    }

    public function reference(): ?string
    {
        return $this->reference;
    }

    public function amountCents(): int
    {
        return $this->amountCents;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function paidAd(): \DateTime
    {
        return $this->paidAd;
    }
}
