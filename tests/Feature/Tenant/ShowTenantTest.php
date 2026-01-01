<?php

use App\Models\TenantModel;

it('shows tenant', function () {
    $model = TenantModel::factory()->create();

    $response = $this->get('/api/tenants/'.$model->id);

    $response->assertStatus(200);
    $this->assertDatabaseHas('tenants', $model->getAttributes());
});
