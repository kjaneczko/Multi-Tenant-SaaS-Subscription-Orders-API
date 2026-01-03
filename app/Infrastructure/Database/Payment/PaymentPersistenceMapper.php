<?php

namespace App\Infrastructure\Database\Payment;

use App\Domain\AmountCents;
use App\Domain\Currency;
use App\Domain\Order\OrderId;
use App\Domain\Payment\Payment;
use App\Domain\Payment\PaymentEntityType;
use App\Domain\Payment\PaymentId;
use App\Domain\Payment\PaymentStatus;
use App\Domain\Tenant\TenantId;
use App\Models\PaymentModel;

final class PaymentPersistenceMapper
{
    public static function toDomain(PaymentModel $model): Payment
    {
        return Payment::reconstitute(
            id: new PaymentId($model->id),
            tenantId: new TenantId($model->tenant_id),
            entityType: PaymentEntityType::from($model->entity_type),
            entityId: $model->entity_id,
            status: PaymentStatus::from($model->status),
            provider: $model->provider,
            reference: $model->reference,
            amountCents: new AmountCents($model->amount_cents),
            currency: Currency::from($model->currency),
            externalId: $model->external_id,
            paidAt: new \DateTimeImmutable($model->paid_at),
            createdAt: new \DateTimeImmutable($model->created_at),
            updatedAt: new \DateTimeImmutable($model->updated_at),
        );
    }

    public static function toPersistence(Payment $payment): array
    {
        return [
            'id' => $payment->id()->toString(),
            'tenant_id' => $payment->tenantId()->toString(),
            'entity_type' => $payment->entityType(),
            'entity_id' => $payment->entityId(),
            'status' => $payment->status()->value,
            'provider' => $payment->provider(),
            'reference' => $payment->reference(),
            'amount_cents' => $payment->amountCents()->toInt(),
            'currency' => $payment->currency()->value,
            'external_id' => $payment->externalId(),
            'paid_at' => $payment->paidAt()?->format('Y-m-d H:i:s'),
            'created_at' => $payment->createdAt()->format('Y-m-d H:i:s'),
            'updated_at' => $payment->updatedAt()->format('Y-m-d H:i:s'),
        ];
    }
}
