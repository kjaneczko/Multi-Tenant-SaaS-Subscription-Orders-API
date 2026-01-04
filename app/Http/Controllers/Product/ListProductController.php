<?php

declare(strict_types=1);

namespace App\Http\Controllers\Product;

use App\Application\Product\Interface\ProductServiceInterface;
use App\Application\Common\Query\PageRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ListProductController extends Controller
{
    public function __invoke(
        Request $request,
        ProductServiceInterface $service,
    ): JsonResponse
    {
        $request->validate([
            'page' => 'sometimes|integer|min:1',
            'limit' => 'sometimes|integer|min:1|max:100',
            'tenant_id' => 'sometimes|uuid',
        ]);

        $pageRequest = new PageRequest(
            page: $request->integer('page', 1),
            limit: $request->integer('limit', 25),
        );

        $tenantId = $request->filled('tenant_id')
            ? $request->string('tenant_id')->toString()
            : null;

        $products = $service->paginate($pageRequest, $tenantId);

        return ProductResource::collection($products)
            ->response()
            ->setStatusCode(Response::HTTP_OK)
        ;
    }
}
