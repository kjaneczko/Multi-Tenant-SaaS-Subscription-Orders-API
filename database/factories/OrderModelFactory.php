<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\OrderModel;
use App\Models\UserModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderModel>
 */
class OrderModelFactory extends Factory
{
    protected $model = OrderModel::class;

    public function definition(): array
    {
        $subtotal = $this->faker->numberBetween(0, 1_000_000);
        $discount = 0;
        $tax = 0;
        $total = $subtotal - $discount + $tax;

        $user = UserModel::factory()->create();

        return [
            'id' => $this->faker->uuid(),
            'tenant_id' => $user->tenant_id,
            'created_by_user_id' => $user->id,
            'customer_email' => $this->faker->safeEmail(),
            'status' => $this->faker->randomElement(['new', 'pending', 'paid', 'cancelled']),
            'currency' => $this->faker->randomElement(['USD', 'EUR']),

            'subtotal_cents' => $subtotal,
            'discount_cents' => $discount,
            'tax_cents' => $tax,
            'total_cents' => $total,

            'notes' => $this->faker->boolean(30) ? $this->faker->sentence() : null,

            'paid_at' => null,
            'refunded_at' => null,
            'cancelled_at' => null,

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
