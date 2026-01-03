<?php

namespace App\Infrastructure\Database\User;

use App\Application\Shared\Query\PageRequest;
use App\Application\User\Interface\UserQueryInterface;
use App\Models\UserModel;

final readonly class UserQueryEloquent implements UserQueryInterface
{
    public function paginate(
        PageRequest $pageRequest,
        ?string $tenantId = null,
        ?string $role = null,
        ?bool $isActive = null,
    ): array {
        // Jeśli u Ciebie PageRequest ma gettery – zamień na:
        // $page = $pageRequest->page();
        // $limit = $pageRequest->limit();
        $page = $pageRequest->page;
        $limit = $pageRequest->limit;

        $query = UserModel::query()->orderByDesc('created_at');

        if ($tenantId !== null && $tenantId !== '') {
            $query->where('tenant_id', $tenantId);
        }

        if ($role !== null && $role !== '') {
            $query->where('role', $role);
        }

        if ($isActive !== null) {
            $query->where('is_active', $isActive);
        }

        $models = $query
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get();

        return $models
            ->map(fn (UserModel $model) => UserPersistenceMapper::toDomain($model))
            ->all();
    }
}
