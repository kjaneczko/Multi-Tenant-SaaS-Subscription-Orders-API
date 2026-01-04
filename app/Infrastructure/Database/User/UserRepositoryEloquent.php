<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\User;

use App\Domain\User\Interface\UserRepositoryInterface;
use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Infrastructure\Database\Exception\DatabaseException;
use App\Models\UserModel;
use Illuminate\Database\QueryException;

final readonly class UserRepositoryEloquent implements UserRepositoryInterface
{
    public function create(User $user): User
    {
        try {
            $attributes = UserPersistenceMapper::toPersistence($user);
            $model = UserModel::create($attributes);
        } catch (QueryException $e) {
            throw DatabaseException::failedToSave($e);
        }

        if (!$model) {
            throw DatabaseException::failedToSave();
        }

        return UserPersistenceMapper::toDomain($model);
    }

    public function update(User $user): bool
    {
        $attributes = UserPersistenceMapper::toPersistence($user);

        try {
            $result = (bool) UserModel::whereKey($user->id()->toString())->update($attributes);
        } catch (QueryException $e) {
            throw DatabaseException::failedToUpdate($e);
        }

        return $result;
    }

    public function delete(UserId $id): bool
    {
        try {
            $result = (bool) UserModel::whereKey($id->toString())->delete();
        } catch (QueryException $e) {
            throw DatabaseException::failedToDelete($e);
        }

        return $result;
    }
}
