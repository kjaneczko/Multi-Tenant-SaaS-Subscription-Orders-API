<?php

namespace app\Domain\Payment;

use App\Domain\Currency;
use app\Domain\Exception\ValidationException;
use app\Domain\Order\OrderId;
use app\Domain\Tenant\TenantId;
use DateTime;

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
        private Currency $currency,
        private DateTime $paidAd,
    ) {
        $this->assertValidProvider($provider);
        $this->assertValidReference($reference);
        $this->assertValidAmountCents($amountCents);
    }

    public static function create(
        PaymentId $id,
        TenantId $tenantId,
        OrderId $orderId,
        PaymentStatus $status,
        string $provider,
        ?string $reference,
        int $amountCents,
        Currency $currency,
        DateTime $paidAd,
    ): self {
        return new self(
            id: $id,
            tenantId: $tenantId,
            orderId: $orderId,
            status: $status,
            provider: $provider,
            reference: $reference,
            amountCents: $amountCents,
            currency: $currency,
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

    public function currency(): Currency
    {
        return $this->currency;
    }

    public function paidAd(): DateTime
    {
        return $this->paidAd;
    }

    public function assertValidProvider(string $provider): void
    {
        if ($provider === '') {
            throw new ValidationException(['provider' => ['Provider is required.']]);
        }
    }

    private function assertValidReference(?string $reference): void
    {
        if (mb_strlen($reference) > 255) {
            throw new ValidationException(['reference' => ['Reference is too long. Must be less than 256 characters.']]);
        }
    }

    private function assertValidAmountCents(int $amountCents): void
    {
        if ($amountCents <= 0) {
            throw new ValidationException(['amount_cents' => ['Amount cannot be less than or equal zero.']]);
        }
    }
}
