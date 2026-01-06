<?php

declare(strict_types=1);

use App\Domain\Currency;
use App\Domain\Order\OrderStatus;
use App\Models\UserModel;

it('creates new order', function () {
    $user = UserModel::factory()->create();

    $payload = [
        'tenant_id' => $user->tenant_id,
        'created_by_user_id' => $user->id,
        'customer_email' => 'customer@example.com',
        'status' => OrderStatus::NEW->value,
        'currency' => Currency::USD->value,
        'subtotal_cents' => 1000,
        'discount_cents' => 0,
        'tax_cents' => 230,
        'total_cents' => 1230,
        'notes' => 'Test order',
        'paid_at' => null,
        'refunded_at' => null,
        'cancelled_at' => null,
    ];

    $response = $this->post('/api/orders/', $payload);

    $response->assertStatus(201);

    $this->assertDatabaseHas('orders', [
        'tenant_id' => $user->tenant_id,
        'customer_email' => 'customer@example.com',
        'status' => OrderStatus::NEW->value,
        'currency' => Currency::USD->value,
        'subtotal_cents' => 1000,
        'discount_cents' => 0,
        'tax_cents' => 230,
        'total_cents' => 1230,
    ]);
});
