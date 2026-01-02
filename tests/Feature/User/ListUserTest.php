<?php

use App\Models\TenantModel;
use App\Models\UserModel;

it('lists users', function () {
    // Uwaga: jeśli masz ograniczenie unique(tenant_id, role),
    // factory może próbować tworzyć kilku userów z tą samą rolą w jednym tenant.
    // Dlatego tworzymy po jednym userze na tenant (factory zwykle losuje role).
    UserModel::factory()->create();
    UserModel::factory()->create();

    $response = $this->get('/api/users/');

    $response->assertStatus(200);

    // Zakładam Resource::collection() => {"data":[...]}
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

