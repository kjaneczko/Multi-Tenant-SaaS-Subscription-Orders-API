<?php

namespace App\Http\Controllers\Product;

use App\Application\Shared\Query\PageRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Infrastructure\Database\Product\ProductPersistenceMapper;
use App\Models\ProductModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class ListProductController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'page' => 'integer|min:1',
            'limit' => 'integer|min:1|max:100',
            'tenant_id' => 'nullable|uuid',
        ]);

        $page = $request->integer('page') ?: 1;
        $limit = $request->integer('limit') ?: 100;
        $tenantId = $request->get('tenant_id');

        $query = ProductModel::query()->orderByDesc('created_at');

        if ($tenantId) {
            $query->where('tenant_id', $tenantId);
        }

        $models = $query
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get();

        // Mapujemy do domeny przez mapper i zwracamy persistence array
        $products = $models
            ->map(fn (ProductModel $m) => ProductPersistenceMapper::toDomain($m))
            ->all();

        return (ProductResource::collection($products))->response()->setStatusCode(Response::HTTP_OK);
    }
}
