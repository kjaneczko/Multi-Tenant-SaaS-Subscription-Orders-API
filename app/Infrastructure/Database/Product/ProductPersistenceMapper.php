<?php

namespace App\Infrastructure\Database\Product;

use App\Domain\Currency;
use App\Domain\Product\Product;
use App\Domain\Product\ProductId;
use App\Domain\Product\ProductStatus;
use App\Domain\PriceCents;
use App\Domain\Sku;
use App\Domain\Slug;
use App\Domain\Tenant\TenantId;
use App\Models\ProductModel;

final class ProductPersistenceMapper
{
    public static function toDomain(ProductModel $model): Product
    {
        return Product::reconstitute(
            id: new ProductId($model->id),
            tenantId: new TenantId($model->tenant_id),
            sku: new Sku($model->sku),
            name: $model->name,
            slug: new Slug($model->slug),
            description: $model->description,
            priceCents: new PriceCents((int) $model->price_cents),
            currency: Currency::from($model->currency),
            status: ProductStatus::from($model->status),
            createdAt: $model->created_at instanceof \DateTimeInterface
                ? \DateTimeImmutable::createFromInterface($model->created_at)
                : new \DateTimeImmutable((string) $model->created_at),
            updatedAt: $model->updated_at instanceof \DateTimeInterface
                ? \DateTimeImmutable::createFromInterface($model->updated_at)
                : new \DateTimeImmutable((string) $model->updated_at),
            deletedAt: $model->deleted_at instanceof \DateTimeInterface
                ? \DateTimeImmutable::createFromInterface($model->deleted_at)
                : ($model->deleted_at ? new \DateTimeImmutable((string)$model->deleted_at) : null),
        );
    }

    public static function toPersistence(Product $product): array
    {
        return [
            'id' => $product->id()->toString(),
            'tenant_id' => $product->tenantId()->toString(),
            'name' => $product->name(),
            'slug' => $product->slug()->toString(),
            'sku' => $product->sku()->toString(),
            'price_cents' => $product->priceCents()->toInt(),
            'status' => $product->status()->value,
            'currency' => $product->currency()->value,
            'description' => $product->description(),
            'created_at' => $product->createdAt()->format('Y-m-d H:i:s'),
            'updated_at' => $product->updatedAt()->format('Y-m-d H:i:s'),
        ];
    }
}
