<?php

namespace app\Domain\Order;

use App\Domain\Currency;
use app\Domain\Exception\ValidationException;
use app\Domain\Tenant\TenantId;
use app\Domain\User\UserId;
use DateTime;

class Order
{
    private function __construct(
        private readonly OrderId  $id,
        private readonly TenantId $tenantId,
        private readonly UserId   $createdByUserId,
        private string            $customerEmail,
        private OrderStatus       $status,
        private Currency          $currency,
        private int               $subtotalCents,
        private int               $discountCents,
        private int               $taxCents,
        private int               $totalCents,
        private ?string           $notes,
        private ?DateTime         $paidAt,
        private ?DateTime         $cancelledAt,
        private ?DateTime         $deletedAt,
    ) {
        $this->assertValidEmail($customerEmail);
        $this->assertValidSubtotalCents($subtotalCents);
        $this->assertValidDiscountCents($discountCents);
        $this->assertValidTaxCents($taxCents);
        $this->assertValidTotalCents($totalCents);
    }

    public static function create(
        OrderId $id,
        TenantId    $tenantId,
        UserId      $createdByUserId,
        string      $customerEmail,
        OrderStatus $status,
        Currency    $currency,
        int         $subtotalCents,
        int         $discountCents,
        int         $taxCents,
        int         $totalCents,
        ?string     $notes,
        ?DateTime   $paidAt,
        ?DateTime   $cancelledAt,
        ?DateTime   $deletedAt,
    ): self {
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

    public function status(): OrderStatus
    {
        return $this->status;
    }

    public function currency(): Currency
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

    public function changeStatus(OrderStatus $status): void
    {
        $this->status = $status;
    }

    public function changeCustomerEmail(string $customerEmail): void
    {
        $this->assertValidEmail($customerEmail);
        $this->customerEmail = $customerEmail;
    }

    public function changeCurrency(Currency $currency): void
    {
        $this->currency = $currency;
    }

    public function changeSubtotalCents(float $subtotalCents): void
    {
        $this->assertValidSubtotalCents($subtotalCents);
        $this->subtotalCents = $subtotalCents;
    }

    public function changeDiscountCents(float $discountCents): void
    {
        $this->assertValidDiscountCents($discountCents);
        $this->discountCents = $discountCents;
    }

    public function changeTaxCents(float $taxCents): void
    {
        $this->assertValidTaxCents($taxCents);
        $this->taxCents = $taxCents;
    }

    public function changeTotalCents(float $totalCents): void
    {
        $this->assertValidTotalCents($totalCents);
        $this->totalCents = $totalCents;
    }

    public function changeNotes(string $notes): void
    {
        $this->notes = $notes;
    }

    public function changePaidAt(DateTime $paidAt): void
    {
        $this->paidAt = $paidAt;
    }

    public function changeCancelledAt(DateTime $cancelledAt): void
    {
        $this->cancelledAt = $cancelledAt;
    }

    public function changeDeletedAt(DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    private function assertValidEmail(string $customerEmail): void
    {
        if (!filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException(
                ['customer_email' => ['Customer email is not a valid email address.']],
            );
        }
    }

    private function assertValidSubtotalCents(int $subtotalCents): void
    {
        if ($subtotalCents < 0) {
            throw new ValidationException(['subtotal_cents' => ['Subtotal must be greater than 0 or equal to 0.']]);
        }
    }

    private function assertValidDiscountCents(int $discountCents): void
    {
        if ($discountCents < 0) {
            throw new ValidationException(['discount_cents' => ['Discount must be greater than 0 or equal to 0.']]);
        }
    }

    private function assertValidTaxCents(int $taxCents): void
    {
        if ($taxCents < 0) {
            throw new ValidationException(['tax_cents' => ['Tax must be greater than 0 or equal to 0.']]);
        }
    }

    private function assertValidTotalCents(int $totalCents): void
    {
        if ($totalCents < 0) {
            throw new ValidationException(['total_cents' => ['Total amount must be greater than 0 or equal to 0.']]);
        }
    }
}
