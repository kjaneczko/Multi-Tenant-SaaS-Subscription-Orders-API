<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Order;

use App\Domain\AmountCents;
use App\Domain\Currency;
use App\Domain\Email;
use App\Domain\Order\Order;
use App\Domain\Order\OrderId;
use App\Domain\Order\OrderStatus;
use App\Domain\Tenant\TenantId;
use App\Domain\User\UserId;
use App\Models\OrderModel;

final class OrderPersistenceMapper
{
    public static function toDomain(OrderModel $model): Order
    {
        return Order::reconstitute(
            id: new OrderId($model->id),
            tenantId: new TenantId($model->tenant_id),
            createdByUserId: new UserId($model->created_by_user_id),
            customerEmail: new Email($model->customer_email),
            status: OrderStatus::from($model->status),
            currency: Currency::from($model->currency),
            subtotalCents: new AmountCents((int) $model->subtotal_cents),
            discountCents: new AmountCents((int) $model->discount_cents),
            taxCents: new AmountCents((int) $model->tax_cents),
            totalCents: new AmountCents((int) $model->total_cents),
            notes: $model->notes,
            paidAt: $model->paid_at
                ? ($model->paid_at instanceof \DateTimeInterface
                    ? \DateTimeImmutable::createFromInterface($model->paid_at)
                    : new \DateTimeImmutable((string) $model->paid_at))
                : null,
            refundedAt: $model->refunded_at
                ? ($model->refunded_at instanceof \DateTimeInterface
                    ? \DateTimeImmutable::createFromInterface($model->refunded_at)
                    : new \DateTimeImmutable((string) $model->refunded_at))
                : null,
            cancelledAt: $model->cancelled_at
                ? ($model->cancelled_at instanceof \DateTimeInterface
                    ? \DateTimeImmutable::createFromInterface($model->cancelled_at)
                    : new \DateTimeImmutable((string) $model->cancelled_at))
                : null,
            deliveredAt: $model->updated_at instanceof \DateTimeInterface
                ? \DateTimeImmutable::createFromInterface($model->updated_at)
                : new \DateTimeImmutable((string) $model->updated_at),
            createdAt: $model->created_at instanceof \DateTimeInterface
                ? \DateTimeImmutable::createFromInterface($model->created_at)
                : new \DateTimeImmutable((string) $model->created_at),
            updatedAt: $model->updated_at instanceof \DateTimeInterface
                ? \DateTimeImmutable::createFromInterface($model->updated_at)
                : new \DateTimeImmutable((string) $model->updated_at),
        );
    }

    public static function toPersistence(Order $order): array
    {
        return [
            'id' => $order->id()->toString(),
            'tenant_id' => $order->tenantId()->toString(),
            'created_by_user_id' => $order->createdByUserId()->toString(),
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
