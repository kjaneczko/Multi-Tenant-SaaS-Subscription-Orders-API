<?php
declare(strict_types=1);

use App\Models\AuditLogModel;

it('shows audit log', function () {
    $model = AuditLogModel::factory()->create();

    $response = $this->get('/api/audit_logs/'.$model->id);

    $response->assertStatus(200);
    $this->assertDatabaseHas('audit_logs', $model->toArray());
});
