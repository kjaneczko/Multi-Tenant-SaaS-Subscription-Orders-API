<?php

namespace app\Domain\OrderItem;

use app\Domain\Order\OrderId;
use app\Domain\Product\ProductId;
use app\Domain\Tenant\TenantId;

readonly class OrderItem
{
    private function __construct(
        private OrderItemId $id,
        private TenantId $tenantId,
        private OrderId $orderId,
        private ProductId $productId,
        private string $productNameSnapshot,
        private string $skuSnapshot,
        private int  $quantity,
        private int $unitPriceCents,
        private int $lineTotalCents,
    ) {}

    public static function create(
        OrderItemId $id,
        TenantId $tenantId,
        OrderId $orderId,
        ProductId $productId,
        string $productNameSnapshot,
        string $skuSnapshot,
        int $quantity,
        int $unitPriceCents,
        int $lineTotalCents,
    ): self
    {
        return new self(
            id: $id,
            tenantId: $tenantId,
            orderId: $orderId,
            productId: $productId,
            productNameSnapshot: $productNameSnapshot,
            skuSnapshot: $skuSnapshot,
            quantity: $quantity,
            unitPriceCents: $unitPriceCents,
            lineTotalCents: $lineTotalCents,
        );
    }

    public function id(): OrderItemId
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
}
