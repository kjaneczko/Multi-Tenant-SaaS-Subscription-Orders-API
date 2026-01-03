<?php

namespace Database\Factories;

use App\Domain\Payment\PaymentEntityType;
use App\Domain\Payment\PaymentStatus;
use App\Models\PaymentModel;
use App\Models\TenantModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PaymentModel>
 */
final class PaymentModelFactory extends Factory
{
    protected $model = PaymentModel::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'tenant_id' => TenantModel::factory(),
            'entity_type' => $this->faker->randomElement(PaymentEntityType::values()),
            'entity_id' => $this->faker->uuid(),
            'status' => $this->faker->randomElement(PaymentStatus::values()),
            'amount_cents' => $this->faker->numberBetween(0, 250000),
            'currency' => $this->faker->randomElement(['USD', 'EUR']),
            'provider' => $this->faker->randomElement(['manual', 'stripe']),
            'reference' => $this->faker->boolean(50) ? $this->faker->uuid() : null,
            'external_id' => $this->faker->uuid(),
        ];
    }
}
