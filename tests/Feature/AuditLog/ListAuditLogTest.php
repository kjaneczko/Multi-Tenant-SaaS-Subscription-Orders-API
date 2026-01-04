<?php
declare(strict_types=1);

use App\Models\AuditLogModel;

it('lists audit logs', function () {
    AuditLogModel::factory()->count(2)->create();

    $response = $this->get('/api/audit_logs/', ['X-Request-Id' => 'xxx']);

    $response->assertStatus(200);
    $response->assertJsonCount(2, 'data');
});
