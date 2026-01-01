<?php

use App\Domain\AuditLog\EntityType;
use App\Infrastructure\UuidGenerator;
use App\Models\UserModel;

it('creates new audit log', function () {
    $actor = UserModel::factory()->create();
    $response = $this->post('/api/audit_logs/', [
        'tenant_id' => $actor->tenant_id,
        'actor_user_id' => $actor->id,
        'action' => EntityType::ORDER->value . '.create',
        'entity_type' => EntityType::ORDER->value,
        'entity_id' => (new UuidGenerator())->generate(),
        'meta' => '{"test":"test meta"}',
    ]);

    $response->assertStatus(201);
});
