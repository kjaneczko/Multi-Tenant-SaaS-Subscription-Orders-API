<?php
declare(strict_types=1);

use App\Domain\Currency;
use App\Domain\Payment\PaymentEntityType;
use App\Domain\Payment\PaymentStatus;
use App\Models\TenantModel;

it('creates payment', function () {
    $tenant = TenantModel::factory()->create();

    $externalId = fake()->uuid();
    $payload = [
        'tenant_id' => $tenant->id,
        'entity_type' => PaymentEntityType::ORDER->value,
        'entity_id' => fake()->uuid(),
        'amount_cents' => 1999,
        'status' => PaymentStatus::PAID->value,
        'currency' => Currency::USD->value,
        'provider' => 'manual',
        'reference' => 'ref-123',
        'external_id' => $externalId,
    ];

    $response = $this->postJson('/api/payments/', $payload);

    $response->assertStatus(201);
    $response->assertJsonStructure(['data' => ['id']]);

    $this->assertDatabaseHas('payments', [
        'tenant_id' => $tenant->id,
        'entity_type' => PaymentEntityType::ORDER->value,
        'amount_cents' => 1999,
        'status' => PaymentStatus::PAID->value,
        'currency' => Currency::USD->value,
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
