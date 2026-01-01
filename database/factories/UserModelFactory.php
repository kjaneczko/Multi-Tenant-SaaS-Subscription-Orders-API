<?php

namespace Database\Factories;

use App\Domain\User\UserRole;
use App\Models\TenantModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserModel>
 */
class UserModelFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'tenant_id' => TenantModel::factory(),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_active' => $this->faker->randomElement(['active', 'inactive']),
            'role' => UserRole::USER,
        ];
    }

    public function userRole(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::USER,
        ]);
    }

    public function adminRole(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::ADMIN,
        ]);
    }

    public function managerRole(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::MANAGER,
        ]);
    }
}
