<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Tenant;

use App\Application\Common\Query\PageRequest;
use App\Domain\Tenant\Interface\TenantRepositoryInterface;
use App\Domain\Tenant\Tenant;
use App\Domain\Tenant\TenantId;
use App\Infrastructure\Database\Exception\DatabaseException;
use App\Models\TenantModel;
use Illuminate\Database\QueryException;

class TenantRepositoryEloquent implements TenantRepositoryInterface
{
    public function getById(TenantId $id): ?Tenant
    {
        $model = TenantModel::find($id->toString());
        if (!$model) {
            return null;
        }

        return TenantPersistenceMapper::toDomain($model);
    }

    public function create(Tenant $tenant): void
    {
        try {
            $model = TenantModel::create(TenantPersistenceMapper::toPersistence($tenant));
        } catch (QueryException $e) {
            throw DatabaseException::failedToSave($e);
        }

        if (!$model) {
            throw DatabaseException::failedToSave();
        }
    }

    public function update(Tenant $tenant): bool
    {
        try {
            $results = TenantModel::whereKey($tenant->id()->toString())->update(TenantPersistenceMapper::toPersistence($tenant));
        } catch (QueryException $e) {
            throw DatabaseException::failedToUpdate($e);
        }

        return $results;
    }

    public function delete(Tenant $tenant): bool
    {
        try {
            $results = TenantModel::whereKey($tenant->id()->toString())->delete();
        } catch (QueryException $e) {
            throw DatabaseException::failedToDelete($e);
        }

        return $results;
    }

    public function getAll(PageRequest $pageRequest): array
    {
        $offset = ($pageRequest->page - 1) * $pageRequest->limit;

        $query = TenantModel::skip($offset)
            ->take($pageRequest->limit)
            ->orderBy('created_at', 'asc')
        ;

        return $query->get()
            ->map(fn (TenantModel $model) => TenantPersistenceMapper::toDomain($model))
            ->all()
        ;
    }
}
