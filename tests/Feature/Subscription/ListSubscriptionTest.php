<?php

declare(strict_types=1);

use App\Domain\Subscription\SubscriptionStatus;
use App\Models\SubscriptionModel;
use App\Models\UserModel;

it('lists subscriptions', function () {
    $userA = UserModel::factory()->create();
    $userB = UserModel::factory()->create();

    $now = now()->format('Y-m-d H:i:s');

    $subscription1 = SubscriptionModel::factory()->create([
        'tenant_id' => $userA->tenant_id,
        'created_by_user_id' => $userA->id,
        'status' => SubscriptionStatus::ACTIVE,
        'started_at' => $now,
        'current_period_start' => $now,
        'current_period_end' => now()->addMonth()->format('Y-m-d H:i:s'),
    ]);
    $start = now()->subMonths(2)->format('Y-m-d H:i:s');
    $end = now()->addMonth()->format('Y-m-d H:i:s');
    $subscription2 = SubscriptionModel::factory()->create([
        'tenant_id' => $userA->tenant_id,
        'created_by_user_id' => $userA->id,
        'status' => SubscriptionStatus::CANCELLED,
        'started_at' => $start,
        'ended_at' => $end,
        'current_period_start' => $start,
        'current_period_end' => $end,
    ]);
    $subscription3 = SubscriptionModel::factory()->create([
        'tenant_id' => $userB->tenant_id,
        'created_by_user_id' => $userB->id,
        'status' => SubscriptionStatus::ACTIVE,
        'started_at' => $now,
        'current_period_start' => $now,
        'current_period_end' => now()->addMonth()->format('Y-m-d H:i:s'),
    ]);

    $response = $this->get('/api/subscriptions/?tenant_id='.$userA->tenant_id.'&status=active');

    $response->assertStatus(200);
    $response->assertJsonCount(1, 'data');

    $response->assertJsonFragment([
        'tenant_id' => $userA->tenant_id,
        'status' => 'active',
    ]);

    $response->assertJsonMissing(['tenant_id' => $userB->tenant_id]);
});
