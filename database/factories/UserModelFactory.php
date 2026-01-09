<?php

namespace Database\Factories;

use App\Models\TenantModel;
use App\Models\UserModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<UserModel>
 */
class UserModelFactory extends Factory
{
    protected $model = UserModel::class;

    public function definition(): array
    {
        $name = $this->faker->name();

        $role = $this->faker->randomElement(['admin', 'manager', 'user']);

        return [
            'id' => (string) Str::uuid(),
            'tenant_id' => TenantModel::factory(),
            'name' => $name,
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => $this->faker->boolean(30) ? now() : null,
            'password' => bcrypt('secret12345'),
            'role' => $role,
            'is_active' => $this->faker->boolean(90),
            'remember_token' => Str::random(10),
        ];
    }

    public function active(): self
    {
        return $this->state(fn () => ['is_active' => true]);
    }

    public function inactive(): self
    {
        return $this->state(fn () => ['is_active' => false]);
    }

    public function role(string $role): self
    {
        return $this->state(fn () => ['role' => $role]);
    }
}
