<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Domain\Product\Product;
use App\Infrastructure\Database\Product\ProductPersistenceMapper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @property Product $resource
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Product $product */
        $product = $this->resource;

        return ProductPersistenceMapper::toPersistence($product);
    }
}
