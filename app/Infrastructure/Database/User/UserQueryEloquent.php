<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\User;

use App\Application\Common\Query\PageRequest;
use App\Domain\User\Interface\UserQueryInterface;
use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Domain\User\UserRole;
use App\Models\UserModel;
use App\Domain\Tenant\TenantId;

final readonly class UserQueryEloquent implements UserQueryInterface
{
    public function getById(UserId $id): ?User
    {
        $model = UserModel::query()->find($id->toString());

        if (!$model) {
            return null;
        }

        return UserPersistenceMapper::toDomain($model);
    }

    public function paginate(
        PageRequest $pageRequest,
        ?TenantId $tenantId = null,
        ?UserRole $role = null,
        ?bool $isActive = null,
    ): array {
        $page = $pageRequest->page;
        $limit = $pageRequest->limit;

        $query = UserModel::query()->orderByDesc('created_at');

        if (null !== $tenantId) {
            $query->where('tenant_id', $tenantId->toString());
        }

        if (null !== $role) {
            $query->where('role', $role->value);
        }

        if (null !== $isActive) {
            $query->where('is_active', $isActive);
        }

        $models = $query
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get()
        ;

        return $models
            ->map(fn (UserModel $model) => UserPersistenceMapper::toDomain($model))
            ->all()
        ;
    }
}
