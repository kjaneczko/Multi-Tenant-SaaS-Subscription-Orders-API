<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\OrderItem;

use App\Domain\OrderItem\Interface\OrderItemRepositoryInterface;
use App\Domain\OrderItem\OrderItem;
use App\Domain\OrderItem\OrderItemId;
use App\Infrastructure\Database\Exception\DatabaseException;
use App\Models\OrderItemModel;
use Illuminate\Database\QueryException;

final readonly class OrderItemRepositoryEloquent implements OrderItemRepositoryInterface
{
    public function create(OrderItem $orderItem): OrderItem
    {
        try {
            $attributes = OrderItemPersistenceMapper::toPersistence($orderItem);
            $model = OrderItemModel::create($attributes);
        } catch (QueryException $e) {
            throw DatabaseException::failedToSave($e);
        }

        if (!$model) {
            throw DatabaseException::failedToSave();
        }

        return OrderItemPersistenceMapper::toDomain($model);
    }

    public function update(OrderItem $orderItem): bool
    {
        try {
            $attributes = OrderItemPersistenceMapper::toPersistence($orderItem);
            $result = (bool) OrderItemModel::whereKey($orderItem->id()->toString())->update($attributes);
        } catch (QueryException $e) {
            throw DatabaseException::failedToUpdate($e);
        }

        return $result;
    }

    public function delete(OrderItemId $id): bool
    {
        try {
            $result = (bool) OrderItemModel::whereKey($id->toString())->delete();
        } catch (QueryException $e) {
            throw DatabaseException::failedToDelete($e);
        }

        return $result;
    }
}
