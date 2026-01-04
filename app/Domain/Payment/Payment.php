<?php

declare(strict_types=1);

namespace App\Domain\Payment;

use App\Domain\AmountCents;
use App\Domain\Currency;
use App\Domain\Exception\ValidationException;
use App\Domain\Tenant\TenantId;

readonly class Payment
{
    private function __construct(
        private PaymentId $id,
        private TenantId $tenantId,
        private PaymentEntityType $entityType,
        private string $entityId,
        private PaymentStatus $status,
        private string $provider,
        private ?string $reference,
        private AmountCents $amountCents,
        private Currency $currency,
        private string $externalId,
        private ?\DateTimeImmutable $paidAt,
        private ?\DateTimeImmutable $createdAt,
        private ?\DateTimeImmutable $updatedAt,
    ) {
        $this->assertValidProvider($provider);
        $this->assertValidReference($reference);
        $this->assertValidAmountCents($amountCents);
    }

    public static function create(
        PaymentId $id,
        TenantId $tenantId,
        PaymentEntityType $entityType,
        string $entityId,
        PaymentStatus $status,
        string $provider,
        ?string $reference,
        AmountCents $amountCents,
        Currency $currency,
        string $externalId,
        ?\DateTimeImmutable $paidAt,
        ?\DateTimeImmutable $createdAt,
        ?\DateTimeImmutable $updatedAt
    ): self {
        return new self(
            id: $id,
            tenantId: $tenantId,
            entityType: $entityType,
            entityId: $entityId,
            status: $status,
            provider: trim($provider),
            reference: null !== $reference ? trim($reference) : null,
            amountCents: $amountCents,
            currency: $currency,
            externalId: $externalId,
            paidAt: $paidAt,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );
    }

    public static function reconstitute(
        PaymentId $id,
        TenantId $tenantId,
        PaymentEntityType $entityType,
        string $entityId,
        PaymentStatus $status,
        string $provider,
        ?string $reference,
        AmountCents $amountCents,
        Currency $currency,
        string $externalId,
        ?\DateTimeImmutable $paidAt,
        ?\DateTimeImmutable $createdAt,
        ?\DateTimeImmutable $updatedAt
    ): self {
        return new self(
            id: $id,
            tenantId: $tenantId,
            entityType: $entityType,
            entityId: $entityId,
            status: $status,
            provider: $provider,
            reference: $reference,
            amountCents: $amountCents,
            currency: $currency,
            externalId: $externalId,
            paidAt: $paidAt,
            createdAt: $createdAt,
            updatedAt: $updatedAt
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

    public function entityType(): PaymentEntityType
    {
        return $this->entityType;
    }

    public function entityId(): string
    {
        return $this->entityId;
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

    public function amountCents(): AmountCents
    {
        return $this->amountCents;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }

    public function externalId(): string
    {
        return $this->externalId;
    }

    public function paidAt(): ?\DateTimeImmutable
    {
        return $this->paidAt;
    }

    public function createdAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    private function assertValidProvider(string $provider): void
    {
        if ('' === $provider) {
            throw new ValidationException(['provider' => ['Provider is required.']]);
        }
    }

    private function assertValidReference(?string $reference): void
    {
        if (null !== $reference && mb_strlen($reference) > 255) {
            throw new ValidationException(['reference' => ['Reference is too long. Must be less than 256 characters.']]);
        }
    }

    private function assertValidAmountCents(AmountCents $amountCents): void
    {
        if (!$amountCents->isPositive()) {
            throw new ValidationException(['amount_cents' => ['Amount cannot be less than or equal zero.']]);
        }
    }
}
