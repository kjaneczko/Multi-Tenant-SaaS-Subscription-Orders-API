<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Domain\Order\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Order $resource
 */
class OrderResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Order $order */
        $order = $this->resource;

        return [
            'id' => $order->id()->toString(),
            'tenant_id' => $order->tenantId()->toString(),
            'created_by_user_id' => $order->createdByUserId(),
            'customer_email' => $order->customerEmail()->toString(),
            'status' => $order->status()->value,
            'currency' => $order->currency()->value,

            'subtotal_cents' => $order->subtotalCents()->toInt(),
            'discount_cents' => $order->discountCents()->toInt(),
            'tax_cents' => $order->taxCents()->toInt(),
            'total_cents' => $order->totalCents()->toInt(),

            'notes' => $order->notes(),

            'paid_at' => $order->paidAt()?->format('Y-m-d H:i:s'),
            'refunded_at' => $order->refundedAt()?->format('Y-m-d H:i:s'),
            'cancelled_at' => $order->cancelledAt()?->format('Y-m-d H:i:s'),

            'created_at' => $order->createdAt()?->format('Y-m-d H:i:s'),
            'updated_at' => $order->updatedAt()?->format('Y-m-d H:i:s'),
        ];
    }
}
