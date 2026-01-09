<?php
declare(strict_types=1);

use App\Models\TenantModel;
use App\Models\UserModel;

it('lists users', function () {
    UserModel::factory()->create();
    UserModel::factory()->create();

    $response = $this->get('/api/users/');

    $response->assertStatus(200);

    $response->assertJsonCount(2, 'data');
});


it('lists users filtered by tenant_id', function () {
    $tenantA = TenantModel::factory()->create();
    $tenantB = TenantModel::factory()->create();

    UserModel::factory()->create([
        'tenant_id' => $tenantA->id,
        'role' => 'admin',
    ]);

    UserModel::factory()->create([
        'tenant_id' => $tenantA->id,
        'role' => 'manager',
    ]);

    UserModel::factory()->create([
        'tenant_id' => $tenantB->id,
        'role' => 'admin',
    ]);

    $response = $this->get('/api/users/?tenant_id=' . $tenantA->id);

    $response->assertStatus(200);
    $response->assertJsonCount(2, 'data');

    $response->assertJsonFragment(['tenant_id' => $tenantA->id]);
    $response->assertJsonMissing(['tenant_id' => $tenantB->id]);
});

