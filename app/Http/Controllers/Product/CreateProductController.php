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
        $request->validate([
            'tenant_id' => 'required|uuid',
            'name' => 'required|string|min:1|max:255',
            'slug' => 'required|string|min:1|max:255',
            'sku' => 'required|string|min:1|max:255',
            'price_cents' => 'required|integer|min:0|max:1000000000',
            'currency' => 'required|string|in:USD,EUR',
            'description' => 'nullable|string|max:2000',
        ]);

        $command = new CreateProductCommand(
            tenantId: new TenantId($request->string('tenant_id')->toString()),
            name: $request->string('name')->toString(),
            slug: new Slug($request->string('slug')->toString()),
            sku: new Sku($request->string('sku')->toString()),
            priceCents: new PriceCents($request->integer('price_cents')),
            currency: Currency::from($request->string('currency')->toString()),
            description: $request->get('description'),
        );

        $id = $handler($command);

        $product = $products->getById(new ProductId($id->toString()));

        return response()->json(
            ProductPersistenceMapper::toPersistence($product),
            Response::HTTP_CREATED
        );
    }
}
