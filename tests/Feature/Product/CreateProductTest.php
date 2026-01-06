<?php
declare(strict_types=1);

use App\Domain\Currency;
use App\Models\TenantModel;

it('creates new product', function () {
    $tenant = TenantModel::factory()->create();

    $payload = [
        'tenant_id' => $tenant->id,
        'name' => 'Test Product',
        'slug' => 'test-product',
        'sku' => 'SKU-TEST-001',
        'price_cents' => 1999,
        'currency' => Currency::USD->value,
        'description' => 'Some description',
    ];

    $response = $this->post('/api/products/', $payload);

    $response->assertStatus(201);

    $this->assertDatabaseHas('products', [
        'tenant_id' => $tenant->id,
        'sku' => 'SKU-TEST-001',
        'slug' => 'test-product',
        'name' => 'Test Product',
        'price_cents' => 1999,
        'currency' => Currency::USD->value,
    ]);
});
