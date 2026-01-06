<?php

declare(strict_types=1);

use App\Models\SubscriptionModel;
use App\Models\UserModel;

it('shows subscription', function () {
    $user = UserModel::factory()->create();

    $subscription = SubscriptionModel::factory()->create(['tenant_id' => $user->tenant_id, 'created_by_user_id' => $user->id]);

    $response = $this->get('/api/subscriptions/'.$subscription->id);

    $response->assertStatus(200);

    $response->assertJsonFragment([
        'id' => $subscription->id,
        'tenant_id' => $user->tenant_id,
        'created_by_user_id' => $user->id,
    ]);
});

it('returns 404 when subscription not found', function () {
    $id = fake()->uuid();

    $response = $this->get('/api/subscriptions/'.$id);

    $response->assertStatus(404);
});
