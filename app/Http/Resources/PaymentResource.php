<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Domain\Payment\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Payment
 */
final class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Payment $payment */
        $payment = $this->resource;

        return [
            'id' => $payment->id()->toString(),
            'tenant_id' => $payment->tenantId()->toString(),
            'entity_type' => $payment->entityType(),
            'entity_id' => $payment->entityId(),
            'status' => $payment->status()->value,
            'amount_cents' => $payment->amountCents()->toInt(),
            'currency' => $payment->currency()->value,
            'provider' => $payment->provider(),
            'reference' => $payment->reference(),
            'paid_at' => $payment->paidAt()?->format('Y-m-d H:i:s'),
            'created_at' => $payment->createdAt()->format('Y-m-d H:i:s'),
            'updated_at' => $payment->updatedAt()->format('Y-m-d H:i:s'),
        ];
    }
}
