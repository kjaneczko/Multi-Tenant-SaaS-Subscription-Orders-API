<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\User;

use App\Domain\Email;
use App\Domain\Tenant\TenantId;
use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Domain\User\UserRole;
use App\Models\UserModel;

class UserPersistenceMapper
{
    public static function toDomain(UserModel $model): User
    {
        $createdAt = $model->created_at instanceof \DateTimeInterface
            ? \DateTimeImmutable::createFromInterface($model->created_at)
            : new \DateTimeImmutable((string) $model->created_at);

        $updatedAt = $model->updated_at instanceof \DateTimeInterface
            ? \DateTimeImmutable::createFromInterface($model->updated_at)
            : new \DateTimeImmutable((string) $model->updated_at);

        $emailVerifiedAt = $model->email_verified_at instanceof \DateTimeInterface
            ? \DateTimeImmutable::createFromInterface($model->email_verified_at)
            : ($model->email_verified_at ? new \DateTimeImmutable((string) $model->email_verified_at) : null);

        $deletedAt = $model->deleted_at instanceof \DateTimeInterface
            ? \DateTimeImmutable::createFromInterface($model->deleted_at)
            : ($model->deleted_at ? new \DateTimeImmutable((string) $model->deleted_at) : null);

        return User::reconstitute(
            id: new UserId($model->id),
            tenantId: new TenantId($model->tenant_id),
            name: $model->name,
            email: new Email($model->email),
            emailVerifiedAt: $emailVerifiedAt,
            password: $model->password,
            role: UserRole::from($model->role),
            isActive: (bool) $model->is_active,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
            deletedAt: $deletedAt,
            rememberToken: $model->remember_token,
        );
    }

    public static function toPersistence(User $user): array
    {
        return [
            'id' => $user->id()->toString(),
            'tenant_id' => $user->tenantId()->toString(),
            'name' => $user->name(),
            'email' => $user->email()->toString(),
            'email_verified_at' => $user->emailVerifiedAt()?->format('Y-m-d H:i:s'),
            'password' => $user->password(),
            'role' => $user->role()->value,
            'is_active' => $user->isActive(),
            'remember_token' => $user->rememberToken(),
            'created_at' => $user->createdAt()->format('Y-m-d H:i:s'),
            'updated_at' => $user->updatedAt()->format('Y-m-d H:i:s'),
            'deleted_at' => $user->deletedAt()?->format('Y-m-d H:i:s'),
        ];
    }
}
