<?php

use App\Models\UserModel;

it('shows user', function () {
    $model = UserModel::factory()->create();

    $response = $this->get('/api/users/' . $model->id);

    $response->assertStatus(200);

    // Smoke-check DB
    $this->assertDatabaseHas('users', [
        'id' => $model->id,
        'tenant_id' => $model->tenant_id,
        'email' => $model->email,
    ]);
});

it('returns 404 when user not found', function () {
    $id = fake()->uuid();

    $response = $this->get('/api/users/' . $id);

    $response->assertStatus(404);
});
