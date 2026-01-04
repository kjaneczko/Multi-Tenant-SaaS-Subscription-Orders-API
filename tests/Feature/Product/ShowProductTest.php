<?php
declare(strict_types=1);

use App\Models\TenantModel;
use Illuminate\Support\Facades\DB;

it('shows product', function () {
    $tenant = TenantModel::factory()->create();

    $id = fake()->uuid();
    $now = now()->format('Y-m-d H:i:s');

    DB::table('products')->insert([
        'id' => $id,
        'tenant_id' => $tenant->id,
        'sku' => 'SKU-SHOW-001',
        'name' => 'Show Product',
        'slug' => 'show-product',
        'description' => null,
        'price_cents' => 2500,
        'currency' => 'USD',
        'status' => 'active',
        'created_at' => $now,
        'updated_at' => $now,
        'deleted_at' => null,
    ]);

    $response = $this->get('/api/products/'.$id);

    $response->assertStatus(200);

    $this->assertDatabaseHas('products', [
        'id' => $id,
        'tenant_id' => $tenant->id,
        'sku' => 'SKU-SHOW-001',
    ]);
});

it('returns 404 when product not found', function () {
    $id = fake()->uuid();

    $response = $this->get('/api/products/'.$id);

    $response->assertStatus(404);
});

