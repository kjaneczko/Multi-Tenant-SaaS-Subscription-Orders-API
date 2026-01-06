<?php

declare(strict_types=1);

use App\Domain\Currency;
use App\Domain\Subscription\SubscriptionInterval;
use App\Domain\Subscription\SubscriptionPlan;
use App\Domain\Subscription\SubscriptionStatus;
use App\Models\UserModel;

it('creates new subscription', function () {
    $user = UserModel::factory()->create();

    $payload = [
        'tenant_id' => $user->tenant_id,
        'created_by_user_id' => $user->id,
        'status' => SubscriptionStatus::ACTIVE->value,
        'currency' => Currency::USD->value,
        'price_cents' => 4900,
        'plan' => SubscriptionPlan::BASIC->value,
        'interval' => SubscriptionInterval::MONTHLY->value,
        'started_at' => now()->format('Y-m-d H:i:s'),
        'current_period_start' => now()->format('Y-m-d H:i:s'),
        'current_period_end' => now()->addMonth()->format('Y-m-d H:i:s'),
        'cancelled_at' => null,
        'ended_at' => null,
    ];

    $response = $this->post('/api/subscriptions/', $payload);

    $response->assertStatus(201);

    $this->assertDatabaseHas('subscriptions', [
        'tenant_id' => $user->tenant_id,
        'created_by_user_id' => $user->id,
        'status' => SubscriptionStatus::ACTIVE->value,
        'currency' => Currency::USD->value,
        'price_cents' => 4900,
        'plan' => SubscriptionPlan::BASIC->value,
        'interval' => SubscriptionInterval::MONTHLY->value,
    ]);
});
