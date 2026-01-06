<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Subscription;

use App\Domain\Subscription\Interface\SubscriptionRepositoryInterface;
use App\Domain\Subscription\Subscription;
use App\Domain\Subscription\SubscriptionId;
use App\Infrastructure\Database\Exception\DatabaseException;
use App\Models\SubscriptionModel;
use Illuminate\Database\QueryException;

final readonly class SubscriptionRepositoryEloquent implements SubscriptionRepositoryInterface
{
    public function create(Subscription $subscription): Subscription
    {
        try {
            $attributes = SubscriptionPersistenceMapper::toPersistence($subscription);
            $model = SubscriptionModel::create($attributes);
        } catch (QueryException $e) {
            throw DatabaseException::failedToSave($e);
        }

        if (!$model) {
            throw DatabaseException::failedToSave();
        }

        return SubscriptionPersistenceMapper::toDomain($model);
    }

    public function update(Subscription $subscription): bool
    {
        try {
            $attributes = SubscriptionPersistenceMapper::toPersistence($subscription);
            $result = (bool) SubscriptionModel::whereKey($subscription->id()->toString())->update($attributes);
        } catch (QueryException $e) {
            throw DatabaseException::failedToUpdate($e);
        }

        return $result;
    }

    public function delete(SubscriptionId $id): bool
    {
        try {
            $result = (bool) SubscriptionModel::whereKey($id->toString())->delete();
        } catch (QueryException $e) {
            throw DatabaseException::failedToDelete($e);
        }

        return $result;
    }
}
