<?php

namespace App\Domain\Order;

use App\Domain\AmountCents;
use App\Domain\Currency;
use App\Domain\Email;
use App\Domain\Exception\ValidationException;
use App\Domain\OrderItem\OrderItemId;
use App\Domain\Tenant\TenantId;
use App\Domain\User\UserId;
use DomainException;

class Order
{
    private function __construct(
        private readonly OrderId $id,
        private readonly TenantId $tenantId,
        private readonly UserId $createdByUserId,
        private Email $customerEmail,
        private OrderStatus                  $status,
        private Currency                     $currency,
        private AmountCents                  $subtotalCents,
        private AmountCents                  $discountCents,
        private AmountCents                  $taxCents,
        private AmountCents                  $totalCents,
        private ?string                      $notes,
        private ?\DateTimeImmutable          $paidAt,
        private ?\DateTimeImmutable          $refundedAt,
        private ?\DateTimeImmutable          $cancelledAt,
        private ?\DateTimeImmutable          $deliveredAt,
        private readonly ?\DateTimeImmutable $createdAt,
        private readonly ?\DateTimeImmutable $updatedAt,
    ) {
        $this->assertValidSubtotalCents($subtotalCents);
        $this->assertValidDiscountCents($discountCents);
        $this->assertValidTaxCents($taxCents);
        $this->assertValidTotalCents($totalCents);
    }

    public static function create(
        OrderId $id,
        TenantId $tenantId,
        UserId $createdByUserId,
        Email $customerEmail,
        OrderStatus $status,
        Currency $currency,
        AmountCents $subtotalCents,
        AmountCents $discountCents,
        AmountCents $taxCents,
        ?string $notes,
        ?\DateTimeImmutable $paidAt,
        ?\DateTimeImmutable $refundedAt,
        ?\DateTimeImmutable $cancelledAt,
        ?\DateTimeImmutable $deliveredAt,
        ?\DateTimeImmutable $createdAt,
        ?\DateTimeImmutable $updatedAt,
    ): self {
        $totalCents = $subtotalCents->sub($discountCents)->add($taxCents);

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
            refundedAt: $refundedAt,
            cancelledAt: $cancelledAt,
            deliveredAt: $deliveredAt,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
        );
    }

    public static function reconstitute(
        OrderId $id,
        TenantId $tenantId,
        UserId $createdByUserId,
        Email $customerEmail,
        OrderStatus $status,
        Currency $currency,
        AmountCents $subtotalCents,
        AmountCents $discountCents,
        AmountCents $taxCents,
        AmountCents $totalCents,
        ?string $notes,
        ?\DateTimeImmutable $paidAt,
        ?\DateTimeImmutable $refundedAt,
        ?\DateTimeImmutable $cancelledAt,
        ?\DateTimeImmutable $deliveredAt,
        ?\DateTimeImmutable $createdAt,
        ?\DateTimeImmutable $updatedAt,
    ): self {
        // totalCents is a book value/snapshot and is not recalculated when read.
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
            refundedAt: $refundedAt,
            cancelledAt: $cancelledAt,
            deliveredAt: $deliveredAt,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
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

    public function customerEmail(): Email
    {
        return $this->customerEmail;
    }

    public function status(): OrderStatus
    {
        return $this->status;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }

    public function subtotalCents(): AmountCents
    {
        return $this->subtotalCents;
    }

    public function discountCents(): AmountCents
    {
        return $this->discountCents;
    }

    public function taxCents(): AmountCents
    {
        return $this->taxCents;
    }

    public function totalCents(): AmountCents
    {
        return $this->totalCents;
    }

    public function notes(): ?string
    {
        return $this->notes;
    }

    public function paidAt(): ?\DateTimeImmutable
    {
        return $this->paidAt;
    }

    public function refundedAt(): ?\DateTimeImmutable
    {
        return $this->refundedAt;
    }

    public function cancelledAt(): ?\DateTimeImmutable
    {
        return $this->cancelledAt;
    }

    public function deliveredAt(): ?\DateTimeImmutable
    {
        return $this->deliveredAt;
    }

    public function createdAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function changeStatus(OrderStatus $status, \DateTimeImmutable $now): void
    {
        if ($status === $this->status) {
            return;
        }

        $allowedTransitions = match ($this->status) {
            OrderStatus::NEW => [
                OrderStatus::WAITING_PAYMENT,
                OrderStatus::CANCELLED,
            ],

            OrderStatus::WAITING_PAYMENT => [
                OrderStatus::PAID,
                OrderStatus::CANCELLED,
            ],

            OrderStatus::PAID => [
                OrderStatus::PENDING,
            ],

            OrderStatus::PENDING => [
                OrderStatus::SENT,
            ],

            OrderStatus::SENT => [
                OrderStatus::DELIVERED,
            ],

            OrderStatus::DELIVERED => [
                OrderStatus::REFUNDED,
            ],

            default => [], // CANCELLED, REFUNDED
        };

        if (!in_array($status, $allowedTransitions, true)) {
            throw new DomainException(
                sprintf(
                    'Cannot change status from %s to %s.',
                    $this->status->value,
                    $status->value
                )
            );
        }

        // Ustaw daty tylko przy wejściu w dany status
        if ($status === OrderStatus::PAID && $this->paidAt === null) {
            $this->paidAt = $now;
        }

        if ($status === OrderStatus::CANCELLED && $this->cancelledAt === null) {
            $this->cancelledAt = $now;
        }

        if ($status === OrderStatus::REFUNDED && $this->refundedAt === null) {
            $this->refundedAt = $now;
        }

        if ($status === OrderStatus::DELIVERED && $this->deliveredAt === null) {
            $this->deliveredAt = $now;
        }

        $this->status = $status;
    }

    public function changeCustomerEmail(Email $customerEmail): void
    {
        $this->checkIfIsEditable();
        $this->customerEmail = $customerEmail;
    }

    public function changeCurrency(Currency $currency): void
    {
        $this->checkIfIsEditable();
        $this->currency = $currency;
    }

    public function changeSubtotalCents(AmountCents $subtotalCents): void
    {
        $this->checkIfIsEditable();
        $this->assertValidSubtotalCents($subtotalCents);
        $this->subtotalCents = $subtotalCents;
        $this->recalculateTotalCents();
    }

    public function changeDiscountCents(AmountCents $discountCents): void
    {
        $this->checkIfIsEditable();
        $this->assertValidDiscountCents($discountCents);
        $this->discountCents = $discountCents;
        $this->recalculateTotalCents();
    }

    public function changeTaxCents(AmountCents $taxCents): void
    {
        $this->checkIfIsEditable();
        $this->assertValidTaxCents($taxCents);
        $this->taxCents = $taxCents;
        $this->recalculateTotalCents();
    }

    public function changeItemQuantity(OrderItemId $id, int $qty): void
    {

    }

    private function recalculateTotalCents(): void
    {
        $totalCents = $this->subtotalCents->sub($this->discountCents)->add($this->taxCents);
        $this->assertValidTotalCents($totalCents);

        $this->totalCents = $totalCents;
    }

    public function changeNotes(string $notes): void
    {
        $this->notes = $notes;
    }

    private function isEditable(): bool
    {
        return in_array($this->status, [OrderStatus::NEW, OrderStatus::WAITING_PAYMENT], true);
    }

    private function checkIfIsEditable(): void
    {
        if (!$this->isEditable()) {
            throw new \DomainException('Order is not editable.');
        }
    }

    private function assertValidSubtotalCents(AmountCents $subtotalCents): void
    {
        if ($subtotalCents->isNegative()) {
            throw new ValidationException(['subtotal_cents' => ['Subtotal cannot be negative.']]);
        }
    }

    private function assertValidDiscountCents(AmountCents $discountCents): void
    {
        if ($discountCents->isNegative()) {
            throw new ValidationException(['discount_cents' => ['Discount cannot be negative.']]);
        }
    }

    private function assertValidTaxCents(AmountCents $taxCents): void
    {
        if ($taxCents->isNegative()) {
            throw new ValidationException(['tax_cents' => ['Tax cannot be negative.']]);
        }
    }

    private function assertValidTotalCents(AmountCents $totalCents): void
    {
        if ($totalCents->isNegative()) {
            throw new ValidationException(['total_cents' => ['Total amount cannot be negative.']]);
        }
    }
}
