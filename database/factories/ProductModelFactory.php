<?php

namespace Database\Factories;

use App\Models\ProductModel;
use App\Models\TenantModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ProductModel>
 */
class ProductModelFactory extends Factory
{
    protected $model = ProductModel::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);

        return [
            'id' => (string) Str::uuid(),

            // jeśli test poda tenant_id ręcznie, to go nie nadpisujemy
            'tenant_id' => TenantModel::factory(),

            'name' => $name,
            'slug' => Str::slug($name),
            'sku' => strtoupper($this->faker->unique()->bothify('SKU-###-????')),

            'description' => $this->faker->boolean(70) ? $this->faker->sentence(10) : null,

            'price_cents' => $this->faker->numberBetween(0, 250000),
            'currency' => $this->faker->randomElement(['USD', 'EUR']),

            // dopasuj, jeśli w domenie masz inne wartości statusu
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
