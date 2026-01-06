<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\OrderItem;

use App\Domain\AmountCents;
use App\Domain\Order\OrderId;
use App\Domain\OrderItem\OrderItem;
use App\Domain\OrderItem\OrderItemId;
use App\Domain\PriceCents;
use App\Domain\Product\ProductId;
use App\Domain\Sku;
use App\Domain\Tenant\TenantId;
use App\Models\OrderItemModel;

final class OrderItemPersistenceMapper
{
    public static function toDomain(OrderItemModel $model): OrderItem
    {
        return OrderItem::reconstitute(
            id: new OrderItemId($model->id),
            tenantId: new TenantId($model->tenant_id),
            orderId: new OrderId($model->order_id),
            productId: new ProductId($model->product_id),
            productNameSnapshot: $model->product_name_snapshot,
            skuSnapshot: new Sku($model->sku_snapshot),
            quantity: (int) $model->quantity,
            unitPriceCents: new PriceCents((int) $model->unit_price_cents),
            lineTotalCents: new AmountCents((int) $model->line_total_cents),
            createdAt: $model->created_at instanceof \DateTimeInterface
                ? \DateTimeImmutable::createFromInterface($model->created_at)
                : new \DateTimeImmutable((string) $model->created_at),
            updatedAt: $model->updated_at instanceof \DateTimeInterface
                ? \DateTimeImmutable::createFromInterface($model->updated_at)
                : new \DateTimeImmutable((string) $model->updated_at),
        );
    }

    public static function toPersistence(OrderItem $orderItem): array
    {
        return [
            'id' => $orderItem->id()->toString(),
            'tenant_id' => $orderItem->tenantId()->toString(),
            'order_id' => $orderItem->orderId()->toString(),
            'product_id' => $orderItem->productId()->toString(),
            'product_name_snapshot' => $orderItem->productNameSnapshot(),
            'sku_snapshot' => $orderItem->skuSnapshot()->toString(),
            'quantity' => $orderItem->quantity(),
            'unit_price_cents' => $orderItem->unitPriceCents()->toInt(),
            'line_total_cents' => $orderItem->lineTotalCents()->toInt(),
            'created_at' => $orderItem->createdAt()?->format('Y-m-d H:i:s'),
            'updated_at' => $orderItem->updatedAt()?->format('Y-m-d H:i:s'),
        ];
    }
}
