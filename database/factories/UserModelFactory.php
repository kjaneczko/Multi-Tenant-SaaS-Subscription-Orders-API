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

        // Uwaga: jeśli w migracji masz unique(['tenant_id','role']),
        // to tworzenie wielu userów w jednym tenant z losową rolą będzie powodowało flaky testy.
        // Ten factory losuje rolę, ale w testach zalecam jawnie podawać tenant_id + role.
        $role = $this->faker->randomElement(['admin', 'manager', 'user']);

        return [
            'id' => (string) Str::uuid(),

            // domyślnie tworzymy tenant
            'tenant_id' => TenantModel::factory(),

            'name' => $name,
            'email' => $this->faker->unique()->safeEmail(),

            // null albo timestamp (zgodnie z kolumną nullable)
            'email_verified_at' => $this->faker->boolean(30) ? now() : null,

            // hasło jako HASH (nie plaintext) — w testach nie musisz znać hasła
            'password' => bcrypt('secret12345'),

            // rola jako string (zgodnie z tabelą)
            'role' => $role,

            // bool zgodnie z tabelą
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
