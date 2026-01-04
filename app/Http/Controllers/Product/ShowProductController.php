<?php

declare(strict_types=1);

namespace App\Http\Controllers\Product;

use App\Application\Product\Interface\ProductServiceInterface;
use App\Application\Product\ProductExecutor;
use App\Domain\Product\ProductId;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ShowProductController extends Controller
{
    public function __invoke(
        string $id,
        ProductServiceInterface $service,
        ProductExecutor $executor,
    ): JsonResponse {
        $product = $service->getById(new ProductId($id));

        return (new ProductResource($product))
            ->response()
            ->setStatusCode(Response::HTTP_OK)
        ;
    }
}
