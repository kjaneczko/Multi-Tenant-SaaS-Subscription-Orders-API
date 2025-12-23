<?php

namespace App\Domain\Payment;

use App\Domain\Currency;
use App\Domain\Exception\ValidationException;
use App\Domain\Order\OrderId;

readonly class Payment
{
    private function __construct(
        private PaymentId           $id,
        private OrderId             $orderId,
        private PaymentStatus       $status,
        private string              $provider,
        private ?string             $reference,
        private int                 $amountCents,
        private Currency            $currency,
        private \DateTime           $paidAt,
        private ?\DateTimeImmutable $createdAt,
        private ?\DateTimeImmutable $updatedAt,
    ) {
        self::assertValidProvider($provider);
        self::assertValidReference($reference);
        self::assertValidAmountCents($amountCents);
    }

    public static function create(
        PaymentId           $id,
        OrderId             $orderId,
        PaymentStatus       $status,
        string              $provider,
        ?string             $reference,
        int                 $amountCents,
        Currency            $currency,
        \DateTime           $paidAt,
        ?\DateTimeImmutable $createdAt,
        ?\DateTimeImmutable $updatedAt
    ): self {
        return new self(
            id: $id,
            orderId: $orderId,
            status: $status,
            provider: trim($provider),
            reference: $reference !== null ? trim($reference) : null,
            amountCents: $amountCents,
            currency: $currency,
            paidAt: $paidAt,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );
    }

    public static function reconstitute(
        PaymentId           $id,
        OrderId             $orderId,
        PaymentStatus       $status,
        string              $provider,
        ?string             $reference,
        int                 $amountCents,
        Currency            $currency,
        \DateTime           $paidAt,
        ?\DateTimeImmutable $createdAt,
        ?\DateTimeImmutable $updatedAt
    ): self {
        self::assertValidProvider($provider);
        self::assertValidReference($reference);
        self::assertValidAmountCents($amountCents);

        return new self(
            id: $id,
            orderId: $orderId,
            status: $status,
            provider: $provider,
            reference: $reference,
            amountCents: $amountCents,
            currency: $currency,
            paidAt: $paidAt,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );
    }

    public function id(): PaymentId
    {
        return $this->id;
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

    public function paidAt(): \DateTime
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

    private static function assertValidProvider(string $provider): void
    {
        if ('' === $provider) {
            throw new ValidationException(['provider' => ['Provider is required.']]);
        }
    }

    private static function assertValidReference(?string $reference): void
    {
        if ($reference !== null && mb_strlen($reference) > 255) {
            throw new ValidationException(['reference' => ['Reference is too long. Must be less than 256 characters.']]);
        }
    }

    private static function assertValidAmountCents(int $amountCents): void
    {
        if ($amountCents <= 0) {
            throw new ValidationException(['amount_cents' => ['Amount cannot be less than or equal zero.']]);
        }
    }
}
