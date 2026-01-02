<?php

namespace App\Http\Controllers\Product;

use App\Application\Product\Interface\ProductRepositoryInterface;
use App\Domain\Product\ProductId;
use App\Http\Controllers\Controller;
use App\Infrastructure\Database\Product\ProductPersistenceMapper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ShowProductController extends Controller
{
    public function __invoke(
        string $id,
        ProductRepositoryInterface $products,
    ): JsonResponse {
        $product = $products->getById(new ProductId($id));

        return response()->json(
            ProductPersistenceMapper::toPersistence($product),
            Response::HTTP_OK
        );
    }
}
