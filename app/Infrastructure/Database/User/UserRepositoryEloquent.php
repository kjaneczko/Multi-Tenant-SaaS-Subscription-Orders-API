<?php

namespace App\Infrastructure\Database\User;

use App\Application\User\Exception\UserNotFoundException;
use App\Application\User\Interface\UserRepositoryInterface;
use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Infrastructure\Database\Exception\DatabaseException;
use App\Models\UserModel;
use Illuminate\Database\QueryException;

final readonly class UserRepositoryEloquent implements UserRepositoryInterface
{
    public function getById(UserId $id): User
    {
        $model = UserModel::query()->find($id->toString());

        if (!$model) {
            throw new UserNotFoundException();
        }

        return UserPersistenceMapper::toDomain($model);
    }

    public function create(User $user): User
    {
        try {
            $attributes = UserPersistenceMapper::toPersistence($user);
            $model = UserModel::create($attributes);
        }
        catch (QueryException $e) {
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
            $result = (bool)UserModel::whereKey($user->id()->toString())->update($attributes);
        }
        catch (QueryException $e) {
            throw DatabaseException::failedToUpdate($e);
        }

        return $result;
    }

    public function delete(UserId $id): bool
    {
        try {
            $result = (bool)UserModel::whereKey($id->toString())->delete();
        }
        catch (QueryException $e) {
            throw DatabaseException::failedToDelete($e);
        }

        return $result;
    }
}
