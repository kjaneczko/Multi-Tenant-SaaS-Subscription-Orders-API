<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Domain\Currency;
use App\Domain\Subscription\SubscriptionInterval;
use App\Domain\Subscription\SubscriptionPlan;
use App\Domain\Subscription\SubscriptionStatus;
use App\Models\SubscriptionModel;
use App\Models\UserModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SubscriptionModel>
 */
class SubscriptionModelFactory extends Factory
{
    protected $model = SubscriptionModel::class;

    public function definition(): array
    {
        $start = now();
        $end = (clone $start)->addMonth();

        $user = UserModel::factory()->create();

        return [
            'id' => $this->faker->uuid(),
            'tenant_id' => $user->tenant_id,
            'created_by_user_id' => $user->id,
            'status' => $this->faker->randomElement(SubscriptionStatus::values()),
            'currency' => $this->faker->randomElement(Currency::values()),
            'plan' => $this->faker->randomElement(SubscriptionPlan::values()),
            'interval' => $this->faker->randomElement(SubscriptionInterval::values()),
            'price_cents' => $this->faker->numberBetween(0, 1_000_000),
            'started_at' => $start,
            'current_period_start' => $start,
            'current_period_end' => $end,
            'cancelled_at' => null,
            'ended_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
