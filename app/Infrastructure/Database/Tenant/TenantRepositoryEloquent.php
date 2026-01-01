<?php

namespace App\Infrastructure\Database\Tenant;

use App\Application\Shared\Query\PageRequest;
use App\Application\Tenant\Exception\TenantNotFoundException;
use App\Domain\Tenant\Interface\TenantRepositoryInterface;
use App\Domain\Tenant\Tenant;
use App\Domain\Tenant\TenantId;
use App\Infrastructure\Database\Exception\DatabaseException;
use App\Models\TenantModel;
use Illuminate\Database\QueryException;

class TenantRepositoryEloquent implements TenantRepositoryInterface
{

    public function create(Tenant $tenant): Tenant
    {
        try {
            $model = TenantModel::create(TenantPersistenceMapper::toPersistence($tenant));
        }
        catch (QueryException $e) {
            throw DatabaseException::failedToSave($e);
        }

        if (!$model) {
            throw DatabaseException::failedToSave();
        }

        return TenantPersistenceMapper::toDomain($model);
    }

    public function update(Tenant $tenant): bool
    {
        try {
            $results = TenantModel::whereKey($tenant->id()->toString())->update(TenantPersistenceMapper::toPersistence($tenant));
        }
        catch (QueryException $e) {
            throw DatabaseException::failedToUpdate($e);
        }

        if (!$results) {
            throw DatabaseException::failedToUpdate();
        }

        return $results;
    }

    public function delete(Tenant $tenant): bool
    {
        try {
            $results = TenantModel::whereKey($tenant->id()->toString())->delete();
        }
        catch (QueryException $e) {
            throw DatabaseException::failedToDelete($e);
        }

        if (!$results) {
            throw DatabaseException::failedToDelete();
        }

        return $results;
    }

    public function findByIdOrFail(TenantId $id): Tenant
    {
        $model = TenantModel::find($id->toString());
        if (!$model) {
            throw new TenantNotFoundException();
        }

        return TenantPersistenceMapper::toDomain($model);
    }

    public function findAll(PageRequest $pageRequest): array
    {
        $offset = ($pageRequest->page - 1) * $pageRequest->limit;

        $query = TenantModel::skip($offset)
            ->take($pageRequest->limit)
            ->orderBy('created_at', 'asc');

        return $query->get()
            ->map(fn (TenantModel $model) => TenantPersistenceMapper::toDomain($model))
            ->all();
    }
}
