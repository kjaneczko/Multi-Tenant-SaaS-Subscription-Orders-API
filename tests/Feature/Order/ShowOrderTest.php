<?php

declare(strict_types=1);

use App\Domain\Currency;
use App\Domain\Order\OrderStatus;
use App\Models\UserModel;
use Illuminate\Support\Facades\DB;

it('shows order', function () {
    $user = UserModel::factory()->create();

    $id = fake()->uuid();
    $now = now()->format('Y-m-d H:i:s');



    DB::table('orders')->insert([
        'id' => $id,
        'tenant_id' => $user->tenant_id,
        'created_by_user_id' => $user->id,
        'customer_email' => 'show@example.com',
        'status' => OrderStatus::NEW->value,
        'currency' => Currency::USD->value,
        'subtotal_cents' => 1000,
        'discount_cents' => 0,
        'tax_cents' => 0,
        'total_cents' => 1000,
        'notes' => null,
        'paid_at' => null,
        'refunded_at' => null,
        'cancelled_at' => null,
        'created_at' => $now,
        'updated_at' => $now,
    ]);

    $response = $this->get('/api/orders/'.$id);

    $response->assertStatus(200);

    $response->assertJsonFragment([
        'id' => $id,
        'tenant_id' => $user->tenant_id,
        'customer_email' => 'show@example.com',
        'status' => OrderStatus::NEW->value,
        'currency' => Currency::USD->value,
    ]);
});

it('returns 404 when order not found', function () {
    $id = fake()->uuid();

    $response = $this->get('/api/orders/'.$id);

    $response->assertStatus(404);
});
