<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Domain\OrderItem\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property OrderItem $resource
 */
class OrderItemResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var OrderItem $orderItem */
        $orderItem = $this->resource;

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
