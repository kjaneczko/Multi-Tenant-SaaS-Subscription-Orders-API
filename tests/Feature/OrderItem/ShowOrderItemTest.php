<?php

declare(strict_types=1);

use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\TenantModel;
use Illuminate\Support\Facades\DB;

it('shows order item', function () {
    $tenant = TenantModel::factory()->create();
    $order = OrderModel::factory()->create(['tenant_id' => $tenant->id]);
    $product = ProductModel::factory()->create(['tenant_id' => $tenant->id]);

    $id = fake()->uuid();
    $now = now()->format('Y-m-d H:i:s');

    DB::table('order_items')->insert([
        'id' => $id,
        'tenant_id' => $tenant->id,
        'order_id' => $order->id,
        'product_id' => $product->id,
        'product_name_snapshot' => 'Show snapshot',
        'sku_snapshot' => 'SKU-SHOW',
        'quantity' => 1,
        'unit_price_cents' => 999,
        'line_total_cents' => 999,
        'created_at' => $now,
        'updated_at' => $now,
    ]);

    $response = $this->get('/api/order-items/'.$id);

    $response->assertStatus(200);

    $response->assertJsonFragment([
        'id' => $id,
        'tenant_id' => $tenant->id,
        'order_id' => $order->id,
        'product_id' => $product->id,
        'sku_snapshot' => 'SKU-SHOW',
    ]);
});

it('returns 404 when order item not found', function () {
    $id = fake()->uuid();

    $response = $this->get('/api/order-items/'.$id);

    $response->assertStatus(404);
});
