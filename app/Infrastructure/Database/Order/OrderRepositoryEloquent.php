<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Order;

use App\Domain\Order\Interface\OrderRepositoryInterface;
use App\Domain\Order\Order;
use App\Domain\Order\OrderId;
use App\Infrastructure\Database\Exception\DatabaseException;
use App\Models\OrderModel;
use Illuminate\Database\QueryException;

final readonly class OrderRepositoryEloquent implements OrderRepositoryInterface
{
    public function create(Order $order): Order
    {
        try {
            $attributes = OrderPersistenceMapper::toPersistence($order);
            $model = OrderModel::create($attributes);
        } catch (QueryException $e) {
            throw DatabaseException::failedToSave($e);
        }

        if (!$model) {
            throw DatabaseException::failedToSave();
        }

        return OrderPersistenceMapper::toDomain($model);
    }

    public function update(Order $order): bool
    {
        try {
            $attributes = OrderPersistenceMapper::toPersistence($order);
            $result = (bool) OrderModel::whereKey($order->id()->toString())->update($attributes);
        } catch (QueryException $e) {
            throw DatabaseException::failedToUpdate($e);
        }

        return $result;
    }

    public function delete(OrderId $id): bool
    {
        try {
            $result = (bool) OrderModel::whereKey($id->toString())->delete();
        } catch (QueryException $e) {
            throw DatabaseException::failedToDelete($e);
        }

        return $result;
    }
}
