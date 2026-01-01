<?php

use App\Models\AuditLogModel;

it('lists audit logs', function () {
    AuditLogModel::factory()->count(2)->create();

    $response = $this->get('/api/audit_logs/');

    $response->assertStatus(200);
    $response->assertJsonCount(2, 'data');
});
