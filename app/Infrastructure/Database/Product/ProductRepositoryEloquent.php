<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Product;

use App\Domain\Product\Interface\ProductRepositoryInterface;
use App\Domain\Product\Product;
use App\Domain\Product\ProductId;
use App\Infrastructure\Database\Exception\DatabaseException;
use App\Models\ProductModel;
use Illuminate\Database\QueryException;

final readonly class ProductRepositoryEloquent implements ProductRepositoryInterface
{
    public function getById(ProductId $id): ?Product
    {
        $model = ProductModel::query()->find($id->toString());
        if (!$model) {
            return null;
        }

        return ProductPersistenceMapper::toDomain($model);
    }

    public function create(Product $product): void
    {
        try {
            $attributes = ProductPersistenceMapper::toPersistence($product);
            $model = ProductModel::create($attributes);
        } catch (QueryException $e) {
            throw DatabaseException::failedToSave($e);
        }

        if (!$model) {
            throw DatabaseException::failedToSave();
        }
    }

    public function update(Product $product): bool
    {
        try {
            $attributes = ProductPersistenceMapper::toPersistence($product);
            $result = (bool) ProductModel::whereKey($product->id()->toString())->update($attributes);
        } catch (QueryException $e) {
            throw DatabaseException::failedToUpdate($e);
        }

        return $result;
    }

    public function delete(ProductId $id): bool
    {
        try {
            $result = (bool) ProductModel::whereKey($id->toString())->delete();
        } catch (QueryException $e) {
            throw DatabaseException::failedToDelete($e);
        }

        return $result;
    }
}
