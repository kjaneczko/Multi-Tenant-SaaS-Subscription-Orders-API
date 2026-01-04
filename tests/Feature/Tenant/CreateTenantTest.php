<?php
declare(strict_types=1);

it('creates new tenant', function () {
    $response = $this->post('/api/tenants/', [
        'name' => 'Test Tenant',
    ]);

    $response->assertStatus(201);
});
