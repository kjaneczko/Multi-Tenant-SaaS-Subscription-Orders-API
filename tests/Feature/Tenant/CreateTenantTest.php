<?php

it('creates new tenant', function () {
    $response = $this->post('/api/tenants/', [
        'name' => 'Test Tenant',
    ]);

    $response->assertStatus(201);
});
