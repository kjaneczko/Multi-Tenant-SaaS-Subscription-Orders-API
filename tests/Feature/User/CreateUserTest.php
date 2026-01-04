<?php
declare(strict_types=1);

use App\Models\TenantModel;

it('creates new user', function () {
    $tenant = TenantModel::factory()->create();

    $payload = [
        'tenant_id' => $tenant->id,
        'name' => 'John Doe',
        'email' => 'john.doe@gmail.com',
        'password' => 'secret12345',
        'role' => 'admin',
    ];

    $response = $this->post('/api/users/', $payload);

    $response->assertStatus(201);

    $this->assertDatabaseHas('users', [
        'tenant_id' => $tenant->id,
        'name' => 'John Doe',
        'email' => 'john.doe@gmail.com',
        'role' => 'admin',
        'is_active' => 1,
    ]);
});
