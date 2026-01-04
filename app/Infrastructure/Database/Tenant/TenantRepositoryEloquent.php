<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Tenant;

use App\Domain\Tenant\Interface\TenantRepositoryInterface;
use App\Domain\Tenant\Tenant;
use App\Infrastructure\Database\Exception\DatabaseException;
use App\Models\TenantModel;
use Illuminate\Database\QueryException;

class TenantRepositoryEloquent implements TenantRepositoryInterface
{
    public function create(Tenant $tenant): Tenant
    {
        try {
            $model = TenantModel::create(TenantPersistenceMapper::toPersistence($tenant));
        } catch (QueryException $e) {
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
}
