<?php
declare(strict_types=1);

use App\Models\TenantModel;

it('lists tenants', function () {
    TenantModel::factory()->count(2)->create();

    $response = $this->get('/api/tenants/');

    $response->assertStatus(200);
    $response->assertJsonCount(2, 'data');
});
