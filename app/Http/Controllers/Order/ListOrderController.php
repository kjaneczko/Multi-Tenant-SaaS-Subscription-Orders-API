<?php

declare(strict_types=1);

namespace App\Http\Controllers\Order;

use App\Application\Common\Query\PageRequest;
use App\Application\Common\UseCaseExecutor;
use App\Application\Order\Command\ListOrderCommand;
use App\Application\Order\Handler\ListOrderHandler;
use App\Domain\Tenant\TenantId;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ListOrderController extends Controller
{
    public function __construct(
        private readonly UseCaseExecutor $executor,
    ) {}

    /**
     * @throws \Throwable
     */
    public function __invoke(
        Request $request,
        ListOrderHandler $handler,
    ): JsonResponse {
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
            ? new TenantId($request->string('tenant_id')->toString())
            : null;

        $command = new ListOrderCommand(
            pageRequest: $pageRequest,
            tenantId: $tenantId,
        );

        $orders = $this->executor->run($command, fn () => ($handler)($command));

        return OrderResource::collection($orders)
            ->response()
            ->setStatusCode(Response::HTTP_OK)
        ;
    }
}
