<?php

declare(strict_types=1);

use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\TenantModel;
use Illuminate\Support\Facades\DB;

it('lists order items', function () {
    $tenantA = TenantModel::factory()->create();
    $tenantB = TenantModel::factory()->create();

    $orderA = OrderModel::factory()->create(['tenant_id' => $tenantA->id]);
    $orderB = OrderModel::factory()->create(['tenant_id' => $tenantB->id]);

    $productA = ProductModel::factory()->create(['tenant_id' => $tenantA->id]);
    $productB = ProductModel::factory()->create(['tenant_id' => $tenantB->id]);

    $now = now()->format('Y-m-d H:i:s');

    DB::table('order_items')->insert([
        [
            'id' => fake()->uuid(),
            'tenant_id' => $tenantA->id,
            'order_id' => $orderA->id,
            'product_id' => $productA->id,
            'product_name_snapshot' => 'A1',
            'sku_snapshot' => 'A01',
            'quantity' => 1,
            'unit_price_cents' => 100,
            'line_total_cents' => 100,
            'created_at' => $now,
            'updated_at' => $now,
        ],
        [
            'id' => fake()->uuid(),
            'tenant_id' => $tenantA->id,
            'order_id' => $orderA->id,
            'product_id' => $productA->id,
            'product_name_snapshot' => 'A2',
            'sku_snapshot' => 'A02',
            'quantity' => 2,
            'unit_price_cents' => 200,
            'line_total_cents' => 400,
            'created_at' => $now,
            'updated_at' => $now,
        ],
        [
            'id' => fake()->uuid(),
            'tenant_id' => $tenantB->id,
            'order_id' => $orderB->id,
            'product_id' => $productB->id,
            'product_name_snapshot' => 'B1',
            'sku_snapshot' => 'B01',
            'quantity' => 1,
            'unit_price_cents' => 999,
            'line_total_cents' => 999,
            'created_at' => $now,
            'updated_at' => $now,
        ],
    ]);

    $response = $this->get('/api/order-items/?tenant_id='.$tenantA->id.'&order_id='.$orderA->id);

    $response->assertStatus(200);
    $response->assertJsonCount(2, 'data');

    $response->assertJsonFragment(['tenant_id' => $tenantA->id]);
    $response->assertJsonMissing(['tenant_id' => $tenantB->id]);
});
