<?php

use App\Models\TenantModel;
use Illuminate\Support\Facades\DB;

it('lists products', function () {
    $tenant = TenantModel::factory()->create();

    $now = now()->format('Y-m-d H:i:s');

    DB::table('products')->insert([
        [
            'id' => fake()->uuid(),
            'tenant_id' => $tenant->id,
            'sku' => 'SKU-LIST-001',
            'name' => 'List Product 1',
            'slug' => 'list-product-1',
            'description' => null,
            'price_cents' => 1000,
            'currency' => 'USD',
            'status' => 'active',
            'created_at' => $now,
            'updated_at' => $now,
            'deleted_at' => null,
        ],
        [
            'id' => fake()->uuid(),
            'tenant_id' => $tenant->id,
            'sku' => 'SKU-LIST-002',
            'name' => 'List Product 2',
            'slug' => 'list-product-2',
            'description' => null,
            'price_cents' => 2000,
            'currency' => 'USD',
            'status' => 'active',
            'created_at' => $now,
            'updated_at' => $now,
            'deleted_at' => null,
        ],
    ]);

    $response = $this->get('/api/products/');

    $response->assertStatus(200);

    $response->assertJsonCount(2, 'data');
});

it('lists products filtered by tenant_id', function () {
    $tenantA = TenantModel::factory()->create();
    $tenantB = TenantModel::factory()->create();

    $now = now()->format('Y-m-d H:i:s');

    DB::table('products')->insert([
        [
            'id' => fake()->uuid(),
            'tenant_id' => $tenantA->id,
            'sku' => 'SKU-TA-001',
            'name' => 'Tenant A Product 1',
            'slug' => 'tenant-a-product-1',
            'description' => null,
            'price_cents' => 1000,
            'currency' => 'USD',
            'status' => 'active',
            'created_at' => $now,
            'updated_at' => $now,
            'deleted_at' => null,
        ],
        [
            'id' => fake()->uuid(),
            'tenant_id' => $tenantA->id,
            'sku' => 'SKU-TA-002',
            'name' => 'Tenant A Product 2',
            'slug' => 'tenant-a-product-2',
            'description' => null,
            'price_cents' => 2000,
            'currency' => 'USD',
            'status' => 'active',
            'created_at' => $now,
            'updated_at' => $now,
            'deleted_at' => null,
        ],
        [
            'id' => fake()->uuid(),
            'tenant_id' => $tenantB->id,
            'sku' => 'SKU-TB-001',
            'name' => 'Tenant B Product 1',
            'slug' => 'tenant-b-product-1',
            'description' => null,
            'price_cents' => 3000,
            'currency' => 'USD',
            'status' => 'active',
            'created_at' => $now,
            'updated_at' => $now,
            'deleted_at' => null,
        ],
    ]);

    $response = $this->get('/api/products/?tenant_id='.$tenantA->id);

    $response->assertStatus(200);

    // Zakładam Resource::collection() format {"data":[...]}
    $response->assertJsonCount(2, 'data');

    // Dodatkowo upewniamy się, że zwrócone elementy należą do tenantA
    $response->assertJsonFragment(['tenant_id' => $tenantA->id]);
    $response->assertJsonMissing(['tenant_id' => $tenantB->id]);
});


