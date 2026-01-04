<?php

declare(strict_types=1);

namespace App\Http\Controllers\Payment;

use App\Application\Common\Query\PageRequest;
use App\Application\Common\UseCaseExecutor;
use App\Application\Payment\Command\ListPaymentCommand;
use App\Application\Payment\Handler\ListPaymentHandler;
use App\Domain\Payment\PaymentEntityType;
use App\Domain\Tenant\TenantId;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ListPaymentController extends Controller
{
    public function __construct(
        private readonly UseCaseExecutor $executor,
    ) {}

    /**
     * @throws \Throwable
     */
    public function __invoke(
        Request $request,
        ListPaymentHandler $handler,
    ): JsonResponse {
        $request->validate([
            'page' => 'sometimes|integer|min:1',
            'limit' => 'sometimes|integer|min:1|max:100',
            'tenant_id' => 'sometimes|uuid',
            'entity_type' => ['sometimes', 'string', Rule::in(PaymentEntityType::values())],
        ]);

        $pageRequest = new PageRequest(
            page: $request->integer('page', 1),
            limit: $request->integer('limit', 25),
        );

        $tenantId = $request->get('tenant_id')
            ? new TenantId($request->string('tenant_id')->toString())
            : null;

        $entityType = $request->get('entity_type')
            ? PaymentEntityType::from($request->string('entity_type')->toString())
            : null;

        $command = new ListPaymentCommand(
            pageRequest: $pageRequest,
            tenantId: $tenantId,
            entityType: $entityType,
        );

        $payments = $this->executor->run($command, fn () => ($handler)($command));

        return PaymentResource::collection($payments)
            ->response()
            ->setStatusCode(Response::HTTP_OK)
        ;
    }
}
