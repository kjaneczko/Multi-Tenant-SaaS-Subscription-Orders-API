<?php

namespace Database\Factories;

use App\Application\Common\AuditCategory;
use App\Domain\EntityType;
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
        $user = UserModel::factory()->create();
        return [
            'id' => $this->faker->uuid(),
            'actor_user_id' => $user->id,
            'tenant_id' => $user->tenant_id,
            'category' => AuditCategory::ACCESS->value,
            'action' => EntityType::AUDIT_LOG->value.'.show',
            'entity_type' => EntityType::AUDIT_LOG,
            'entity_id' => $this->faker->uuid(),
            'payload' => '{"test":"test"}',
            'duration_ms' => 10,
            'success' => true,
            'error_type' => null,
            'error_message' => null,
            'request_id' => $this->faker->uuid(),
            'ip' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
            'created_at' => $this->faker->dateTime(),
        ];
    }
}
