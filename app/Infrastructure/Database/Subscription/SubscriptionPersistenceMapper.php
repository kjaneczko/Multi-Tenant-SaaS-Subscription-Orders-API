<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Subscription;

use App\Domain\Currency;
use App\Domain\PriceCents;
use App\Domain\Subscription\Subscription;
use App\Domain\Subscription\SubscriptionId;
use App\Domain\Subscription\SubscriptionInterval;
use App\Domain\Subscription\SubscriptionPlan;
use App\Domain\Subscription\SubscriptionStatus;
use App\Domain\Tenant\TenantId;
use App\Domain\User\UserId;
use App\Models\SubscriptionModel;

final class SubscriptionPersistenceMapper
{
    public static function toDomain(SubscriptionModel $model): Subscription
    {
        return Subscription::reconstitute(
            id: new SubscriptionId($model->id),
            tenantId: new TenantId($model->tenant_id),
            createdByUserId: new UserId($model->created_by_user_id),
            plan: SubscriptionPlan::from($model->plan),
            interval: SubscriptionInterval::from($model->interval),
            status: SubscriptionStatus::from($model->status),
            currency: Currency::from($model->currency),
            priceCents: new PriceCents((int) $model->price_cents),
            startedAt: $model->started_at instanceof \DateTimeInterface
                ? \DateTimeImmutable::createFromInterface($model->started_at)
                : new \DateTimeImmutable((string) $model->started_at),
            endedAt: $model->ended_at
                ? ($model->ended_at instanceof \DateTimeInterface
                    ? \DateTimeImmutable::createFromInterface($model->ended_at)
                    : new \DateTimeImmutable((string) $model->ended_at))
                : null,
            currentPeriodStart: $model->current_period_start instanceof \DateTimeInterface
                ? \DateTimeImmutable::createFromInterface($model->current_period_start)
                : new \DateTimeImmutable((string) $model->current_period_start),
            currentPeriodEnd: $model->current_period_end instanceof \DateTimeInterface
                ? \DateTimeImmutable::createFromInterface($model->current_period_end)
                : new \DateTimeImmutable((string) $model->current_period_end),
            cancelledAt: $model->cancelled_at
                ? ($model->cancelled_at instanceof \DateTimeInterface
                    ? \DateTimeImmutable::createFromInterface($model->cancelled_at)
                    : new \DateTimeImmutable((string) $model->cancelled_at))
                : null,
            createdAt: $model->created_at instanceof \DateTimeInterface
                ? \DateTimeImmutable::createFromInterface($model->created_at)
                : new \DateTimeImmutable((string) $model->created_at),
            updatedAt: $model->updated_at instanceof \DateTimeInterface
                ? \DateTimeImmutable::createFromInterface($model->updated_at)
                : new \DateTimeImmutable((string) $model->updated_at),
        );
    }

    public static function toPersistence(Subscription $subscription): array
    {
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
