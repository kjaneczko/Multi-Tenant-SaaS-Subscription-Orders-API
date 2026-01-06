<?php

declare(strict_types=1);

namespace App\Http\Controllers\OrderItem;

use App\Application\Common\UseCaseExecutor;
use App\Application\OrderItem\Command\CreateOrderItemCommand;
use App\Application\OrderItem\Handler\CreateOrderItemHandler;
use App\Domain\Order\OrderId;
use App\Domain\PriceCents;
use App\Domain\Product\ProductId;
use App\Domain\Sku;
use App\Domain\Tenant\TenantId;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderItemResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateOrderItemController extends Controller
{
    public function __construct(
        private readonly UseCaseExecutor $executor,
    ) {}

    /**
     * @throws \Throwable
     */
    public function __invoke(
        Request $request,
        CreateOrderItemHandler $handler,
    ): JsonResponse {
        $request->validate([
            'tenant_id' => 'required|uuid',
            'order_id' => 'required|uuid',
            'product_id' => 'required|uuid',
            'product_name_snapshot' => 'required|string|max:255',
            'sku_snapshot' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1|max:1000000',
            'unit_price_cents' => 'required|integer|min:0|max:1000000000',
            'line_total_cents' => 'required|integer|min:0|max:1000000000',
        ]);

        $command = new CreateOrderItemCommand(
            tenantId: new TenantId($request->get('tenant_id')),
            orderId: new OrderId($request->get('order_id')),
            productId: new ProductId($request->get('product_id')),
            productNameSnapshot: $request->get('product_name_snapshot'),
            skuSnapshot: new Sku($request->get('sku_snapshot')),
            quantity: $request->integer('quantity'),
            unitPriceCents: new PriceCents($request->integer('unit_price_cents')),
        );

        $orderItem = $this->executor->run($command, fn () => ($handler)($command));

        return (new OrderItemResource($orderItem))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED)
        ;
    }
}
