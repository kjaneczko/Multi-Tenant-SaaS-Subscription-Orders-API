<?php
declare(strict_types=1);

use App\Models\PaymentModel;

it('shows payment', function () {
    $payment = PaymentModel::factory()->create();

    $response = $this->getJson('/api/payments/' . $payment->id);

    $response->assertStatus(200);
    $response->assertJsonPath('data.id', $payment->id);
});


it('returns 404 when payment not found', function () {
    $response = $this->getJson('/api/payments/' . fake()->uuid());

    $response->assertStatus(404);
});
