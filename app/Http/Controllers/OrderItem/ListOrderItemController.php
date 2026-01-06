<?php

declare(strict_types=1);

namespace App\Http\Controllers\OrderItem;

use App\Application\Common\Query\PageRequest;
use App\Application\Common\UseCaseExecutor;
use App\Application\OrderItem\Command\ListOrderItemCommand;
use App\Application\OrderItem\Handler\ListOrderItemHandler;
use App\Domain\Tenant\TenantId;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderItemResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ListOrderItemController extends Controller
{
    public function __construct(
        private readonly UseCaseExecutor $executor,
    ) {}

    /**
     * @throws \Throwable
     */
    public function __invoke(
        Request $request,
        ListOrderItemHandler $handler,
    ): JsonResponse {
        $request->validate([
            'page' => 'sometimes|integer|min:1',
            'limit' => 'sometimes|integer|min:1|max:100',
            'tenant_id' => 'sometimes|uuid',
            'order_id' => 'sometimes|uuid',
        ]);

        $pageRequest = new PageRequest(
            page: $request->integer('page', 1),
            limit: $request->integer('limit', 25),
        );

        $tenantId = $request->filled('tenant_id')
            ? new TenantId($request->string('tenant_id')->toString())
            : null;

        $orderId = $request->filled('order_id')
            ? $request->string('order_id')->toString()
            : null;

        $command = new ListOrderItemCommand(
            pageRequest: $pageRequest,
            tenantId: $tenantId,
            orderId: $orderId,
        );

        $orderItems = $this->executor->run($command, fn () => ($handler)($command));

        return OrderItemResource::collection($orderItems)
            ->response()
            ->setStatusCode(Response::HTTP_OK)
        ;
    }
}
