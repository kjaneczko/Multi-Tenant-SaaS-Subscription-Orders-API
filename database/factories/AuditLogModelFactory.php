<?php

namespace Database\Factories;

use App\Domain\AuditLog\EntityType;
use App\Models\TenantModel;
use App\Models\UserModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AuditLogModel>
 */
class AuditLogModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'actor_user_id' => UserModel::factory(),
            'tenant_id' => TenantModel::factory(),
            'action' => $this->faker->word(),
            'entity_type' => EntityType::ORDER,
            'entity_id' => $this->faker->uuid(),
            'meta' => '{"test":"test"}',
            'created_at' => $this->faker->dateTime(),
        ];
    }

    public function withEntityType(EntityType $entityType): static
    {
        return $this->state(fn (array $attributes) => [
            'entity_type' => $entityType->value,
        ]);
    }
}
