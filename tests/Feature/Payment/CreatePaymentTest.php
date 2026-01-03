<?php

use App\Models\TenantModel;

it('creates payment', function () {
    $tenant = TenantModel::factory()->create();

    $externalId = fake()->uuid();
    $payload = [
        'tenant_id' => $tenant->id,
        'entity_type' => 'order',
        'entity_id' => fake()->uuid(),
        'status' => 'paid',
        'amount_cents' => 1999,
        'currency' => 'USD',
        'provider' => 'manual',
        'reference' => 'ref-123',
        'external_id' => $externalId,
    ];

    $response = $this->postJson('/api/payments/', $payload);

    $response->assertStatus(201);
    $response->assertJsonStructure(['data' => ['id']]);

    $this->assertDatabaseHas('payments', [
        'tenant_id' => $tenant->id,
        'entity_type' => 'order',
        'status' => 'paid',
        'amount_cents' => 1999,
        'currency' => 'USD',
        'provider' => 'manual',
        'reference' => 'ref-123',
        'external_id' => $externalId,
    ]);
});

it('validates create payment request', function () {
    $response = $this->postJson('/api/payments/', []);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors([
        'tenant_id',
        'entity_type',
        'entity_id',
        'status',
        'amount_cents',
        'currency',
        'provider',
    ]);
});
