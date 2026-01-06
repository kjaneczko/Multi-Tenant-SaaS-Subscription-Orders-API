<?php

declare(strict_types=1);

use App\Models\OrderModel;
use App\Models\UserModel;

it('lists orders', function () {
    $userA = UserModel::factory()->create();
    $userB = UserModel::factory()->create();

    OrderModel::factory()->create([
        'tenant_id' => $userA->tenant_id,
        'created_by_user_id' => $userA->id,
        'customer_email' => 'a1@example.com',
    ]);
    OrderModel::factory()->create([
        'tenant_id' => $userA->tenant_id,
        'created_by_user_id' => $userA->id,
        'customer_email' => 'a2@example.com',
    ]);
    OrderModel::factory()->create([
        'tenant_id' => $userB->tenant_id,
        'created_by_user_id' => $userB->id,
        'customer_email' => 'b1@example.com',
    ]);

    $response = $this->get('/api/orders/?tenant_id='.$userA->tenant_id);

    $response->assertStatus(200);

    $response->assertJsonCount(2, 'data');

    $response->assertJsonFragment(['tenant_id' => $userA->tenant_id]);
    $response->assertJsonMissing(['tenant_id' => $userB->tenant_id]);
});
