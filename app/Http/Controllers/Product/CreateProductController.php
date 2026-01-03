<?php

namespace App\Http\Controllers\Product;

use App\Application\Product\Command\CreateProductCommand;
use App\Application\Product\Handler\CreateProductHandler;
use App\Application\Product\Interface\ProductRepositoryInterface;
use App\Domain\Currency;
use App\Domain\PriceCents;
use App\Domain\Product\ProductId;
use App\Domain\Sku;
use App\Domain\Slug;
use App\Domain\Tenant\TenantId;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Infrastructure\Database\Product\ProductPersistenceMapper;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateProductController extends Controller
{
    public function __invoke(
        Request $request,
        CreateProductHandler $handler,
        ProductRepositoryInterface $products,
    ): JsonResponse {
        $validated = $request->validate([
            'tenant_id' => 'required|uuid',
            'name' => 'required|string|min:1|max:255',
            'slug' => 'required|string|min:1|max:255',
            'sku' => 'required|string|min:1|max:255',
            'price_cents' => 'required|integer|min:0|max:1000000000',
            'currency' => 'required|string|in:USD,EUR',
            'description' => 'nullable|string|max:2000',
        ]);

        $command = new CreateProductCommand(
            tenantId: new TenantId($validated['tenant_id']),
            name: $validated['name'],
            slug: new Slug($validated['slug']),
            sku: new Sku($validated['sku']),
            priceCents: new PriceCents((int) $validated['price_cents']),
            currency: Currency::from($validated['currency']),
            description: $validated['description'] ?? null,
        );

        $id = $handler($command);

        $product = $products->getById(new ProductId($id->toString()));

        return (new ProductResource($product))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
