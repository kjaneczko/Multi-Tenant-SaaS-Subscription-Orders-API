<?php

declare(strict_types=1);

use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\UserModel;

it('creates new order item', function () {
    $user = UserModel::factory()->create();
    $order = OrderModel::factory()->create(['tenant_id' => $user->tenant_id, 'created_by_user_id' => $user->id]);
    $product = ProductModel::factory()->create(['tenant_id' => $user->tenant_id]);

    $payload = [
        'tenant_id' => $user->tenant_id,
        'order_id' => $order->id,
        'product_id' => $product->id,
        'product_name_snapshot' => 'Product snapshot',
        'sku_snapshot' => 'SKU-001',
        'quantity' => 2,
        'unit_price_cents' => 1500,
        'line_total_cents' => 3000,
    ];

    $response = $this->post('/api/order-items/', $payload);

    $response->assertStatus(201);

    $this->assertDatabaseHas('order_items', [
        'tenant_id' => $user->tenant_id,
        'order_id' => $order->id,
        'product_id' => $product->id,
        'product_name_snapshot' => 'Product snapshot',
        'sku_snapshot' => 'SKU-001',
        'quantity' => 2,
        'unit_price_cents' => 1500,
        'line_total_cents' => 3000,
    ]);
});
