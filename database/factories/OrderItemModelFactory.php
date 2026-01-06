<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\TenantModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderItemModel>
 */
class OrderItemModelFactory extends Factory
{
    protected $model = OrderItemModel::class;

    public function definition(): array
    {
        $tenant = TenantModel::factory()->create();

        $order = OrderModel::factory()->create(['tenant_id' => $tenant->id]);
        $product = ProductModel::factory()->create(['tenant_id' => $tenant->id]);

        $quantity = $this->faker->numberBetween(1, 100);
        $unitPrice = $this->faker->numberBetween(0, 1_000_000);
        $lineTotal = $quantity * $unitPrice;

        return [
            'id' => $this->faker->uuid(),
            'tenant_id' => $tenant->id,
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name_snapshot' => $this->faker->word(),
            'sku_snapshot' => strtoupper($this->faker->bothify('SKU-###')),
            'quantity' => $quantity,
            'unit_price_cents' => $unitPrice,
            'line_total_cents' => $lineTotal,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
