<?php
declare(strict_types=1);

use App\Domain\EntityType;
use App\Models\PaymentModel;
use App\Models\TenantModel;

it('lists payments', function () {
    PaymentModel::factory()->create();
    PaymentModel::factory()->create();

    $response = $this->getJson('/api/payments/');

    $response->assertStatus(200);
    $response->assertJsonCount(2, 'data');
});


it('lists payments filtered by tenant_id', function () {
    $tenantA = TenantModel::factory()->create();
    $tenantB = TenantModel::factory()->create();

    PaymentModel::factory()->create(['tenant_id' => $tenantA->id]);
    PaymentModel::factory()->create(['tenant_id' => $tenantA->id]);
    PaymentModel::factory()->create(['tenant_id' => $tenantB->id]);

    $response = $this->getJson('/api/payments/?tenant_id=' . $tenantA->id);

    $response->assertStatus(200);
    $response->assertJsonCount(2, 'data');
    $response->assertJsonMissing(['tenant_id' => $tenantB->id]);
});

it('lists payments filtered by entity_type', function () {
    PaymentModel::factory()->create(['entity_type' => EntityType::ORDER->value]);
    PaymentModel::factory()->create(['entity_type' => EntityType::ORDER->value]);
    PaymentModel::factory()->create(['entity_type' => EntityType::SUBSCRIPTION->value]);

    $response = $this->getJson('/api/payments/?entity_type=order');

    $response->assertStatus(200);
    $response->assertJsonCount(2, 'data');
});
