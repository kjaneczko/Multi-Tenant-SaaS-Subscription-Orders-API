<?php

namespace app\Domain\OrderItem;

use app\Domain\Exception\ValidationException;
use app\Domain\Order\OrderId;
use app\Domain\Product\ProductId;
use app\Domain\Tenant\TenantId;
use DateTimeImmutable;

class OrderItem
{
    private function __construct(
        private readonly OrderItemId        $id,
        private readonly OrderId            $orderId,
        private readonly ProductId          $productId,
        private readonly string             $productNameSnapshot,
        private readonly string             $skuSnapshot,
        private int                         $quantity,
        private int                         $unitPriceCents,
        private int                         $lineTotalCents,
        private readonly ?DateTimeImmutable $createdAt,
        private readonly ?DateTimeImmutable $updatedAt,
    ) {
        $this->assertValidQuantity($quantity);
        $this->assertValidUnitPriceCents($unitPriceCents);
        $this->assertValidLineTotalCents($lineTotalCents);
    }

    public static function create(
        OrderItemId $id,
        OrderId $orderId,
        ProductId $productId,
        string $productNameSnapshot,
        string $skuSnapshot,
        int $quantity,
        int $unitPriceCents,
        int $lineTotalCents,
        ?DateTimeImmutable $createdAt,
        ?DateTimeImmutable $updatedAt
    ): self {
        return new self(
            id: $id,
            orderId: $orderId,
            productId: $productId,
            productNameSnapshot: $productNameSnapshot,
            skuSnapshot: $skuSnapshot,
            quantity: $quantity,
            unitPriceCents: $unitPriceCents,
            lineTotalCents: $lineTotalCents,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
        );
    }

    public function id(): OrderItemId
    {
        return $this->id;
    }

    public function orderId(): OrderId
    {
        return $this->orderId;
    }

    public function productId(): ProductId
    {
        return $this->productId;
    }

    public function productNameSnapshot(): string
    {
        return $this->productNameSnapshot;
    }

    public function skuSnapshot(): string
    {
        return $this->skuSnapshot;
    }

    public function quantity(): int
    {
        return $this->quantity;
    }

    public function unitPriceCents(): int
    {
        return $this->unitPriceCents;
    }

    public function lineTotalCents(): int
    {
        return $this->lineTotalCents;
    }

    public function createdAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function changeQuantity(int $quantity): void
    {
        $this->assertValidQuantity($quantity);
        $this->quantity = $quantity;
    }

    public function changeUnitPriceCents(int $unitPriceCents): void
    {
        $this->assertValidUnitPriceCents($unitPriceCents);
        $this->unitPriceCents = $unitPriceCents;
    }

    public function changeLineTotalCents(int $lineTotalCents): void
    {
        $this->assertValidLineTotalCents($lineTotalCents);
        $this->lineTotalCents = $lineTotalCents;
    }

    private function assertValidQuantity(int $quantity): void
    {
        if ($quantity < 0) {
            throw new ValidationException(
                ['quantity' => ['Quantity must be greater than 0.']],
            );
        }
    }

    private function assertValidUnitPriceCents(int $unitPriceCents): void
    {
        if ($unitPriceCents < 0) {
            throw new ValidationException(
                ['unit_price_cents' => ['Unit price must be greater than 0.']],
            );
        }
    }

    private function assertValidLineTotalCents(int $lineTotalCents): void
    {
        if ($lineTotalCents < 0) {
            throw new ValidationException(
                ['line_total_cents' => ['Line total must be greater than 0.']],
            );
        }
    }
}
