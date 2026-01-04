<?php

declare(strict_types=1);

namespace App\Http\Controllers\Product;

use App\Application\Common\UseCaseExecutor;
use App\Application\Product\Command\CreateProductCommand;
use App\Application\Product\Handler\CreateProductHandler;
use App\Domain\Currency;
use App\Domain\PriceCents;
use App\Domain\Sku;
use App\Domain\Slug;
use App\Domain\Tenant\TenantId;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateProductController extends Controller
{
    public function __construct(
        private readonly UseCaseExecutor $executor,
    )
    {
    }

    /**
     * @throws \Throwable
     */
    public function __invoke(
        Request $request,
        CreateProductHandler $handler,
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
            tenantId: new TenantId($request->get('tenant_id')),
            name: $request->get('name'),
            slug: new Slug($request->get('slug')),
            sku: new Sku($request->get('sku')),
            priceCents: new PriceCents($request->integer('price_cents')),
            currency: Currency::from($request->get('currency')),
            description: $request->get('description') ?? null,
        );

        $product = $this->executor->run($command, fn() => ($handler)($command));

        return (new ProductResource($product))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED)
        ;
    }
}
