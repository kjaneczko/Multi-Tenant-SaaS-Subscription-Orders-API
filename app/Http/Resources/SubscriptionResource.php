<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Domain\Subscription\Subscription;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Subscription $resource
 */
class SubscriptionResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Subscription $subscription */
        $subscription = $this->resource;

        return [
            'id' => $subscription->id()->toString(),
            'tenant_id' => $subscription->tenantId()->toString(),
            'created_by_user_id' => $subscription->createdByUserId()->toString(),
            'status' => $subscription->status()->value,
            'currency' => $subscription->currency()->value,
            'price_cents' => $subscription->priceCents()->toInt(),
            'plan' => $subscription->plan()->value,
            'interval' => $subscription->interval()->value,
            'started_at' => $subscription->startedAt()->format('Y-m-d H:i:s'),
            'current_period_start' => $subscription->currentPeriodStart()->format('Y-m-d H:i:s'),
            'current_period_end' => $subscription->currentPeriodEnd()->format('Y-m-d H:i:s'),
            'cancelled_at' => $subscription->cancelledAt()?->format('Y-m-d H:i:s'),
            'ended_at' => $subscription->endedAt()?->format('Y-m-d H:i:s'),
            'created_at' => $subscription->createdAt()?->format('Y-m-d H:i:s'),
            'updated_at' => $subscription->updatedAt()?->format('Y-m-d H:i:s'),
        ];
    }
}
