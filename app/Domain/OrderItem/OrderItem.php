<?php

namespace App\Domain\OrderItem;

use App\Domain\AmountCents;
use App\Domain\Exception\ValidationException;
use App\Domain\Order\OrderId;
use App\Domain\PriceCents;
use App\Domain\Product\ProductId;
use App\Domain\Sku;

class OrderItem
{
    private function __construct(
        private readonly OrderItemId $id,
        private readonly OrderId $orderId,
        private readonly ProductId $productId,
        private readonly string $productNameSnapshot,
        private readonly Sku $skuSnapshot,
        private int $quantity,
        private PriceCents $unitPriceCents,
        private AmountCents $lineTotalCents,
        private readonly ?\DateTimeImmutable $createdAt,
        private readonly ?\DateTimeImmutable $updatedAt,
    ) {
        $this->assertValidQuantity($quantity);
    }

    public static function create(
        OrderItemId $id,
        OrderId $orderId,
        ProductId $productId,
        string $productNameSnapshot,
        Sku $skuSnapshot,
        int $quantity,
        PriceCents $unitPriceCents,
        ?\DateTimeImmutable $createdAt,
        ?\DateTimeImmutable $updatedAt
    ): self {
        $lineTotalCents = new AmountCents($unitPriceCents->toInt() * $quantity);
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

    public static function reconstitute(
        OrderItemId $id,
        OrderId $orderId,
        ProductId $productId,
        string $productNameSnapshot,
        Sku $skuSnapshot,
        int $quantity,
        PriceCents $unitPriceCents,
        AmountCents $lineTotalCents,
        ?\DateTimeImmutable $createdAt,
        ?\DateTimeImmutable $updatedAt
    ): self {
        // lineTotalCents is a book value/snapshot and is not recalculated when read.
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

    public function skuSnapshot(): Sku
    {
        return $this->skuSnapshot;
    }

    public function quantity(): int
    {
        return $this->quantity;
    }

    public function unitPriceCents(): PriceCents
    {
        return $this->unitPriceCents;
    }

    public function lineTotalCents(): AmountCents
    {
        return $this->lineTotalCents;
    }

    public function createdAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function changeQuantity(int $quantity): void
    {
        $this->assertValidQuantity($quantity);
        $this->quantity = $quantity;
        $this->recalculateLineTotalCents();
    }

    public function changeUnitPriceCents(PriceCents $unitPriceCents): void
    {
        $this->unitPriceCents = $unitPriceCents;
        $this->recalculateLineTotalCents();
    }

    private function recalculateLineTotalCents(): void
    {
        $this->lineTotalCents = new AmountCents($this->unitPriceCents->toInt() * $this->quantity);
    }

    private function assertValidQuantity(int $quantity): void
    {
        if ($quantity <= 0) {
            throw new ValidationException(
                ['quantity' => ['Quantity must be greater than 0.']],
            );
        }
    }
}
