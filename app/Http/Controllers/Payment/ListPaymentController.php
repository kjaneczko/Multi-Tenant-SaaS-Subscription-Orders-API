<?php

declare(strict_types=1);

namespace App\Http\Controllers\Payment;

use App\Application\Payment\Interface\PaymentServiceInterface;
use App\Application\Common\Query\PageRequest;
use App\Domain\Payment\PaymentEntityType;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ListPaymentController extends Controller
{
    public function __invoke(
        Request $request,
        PaymentServiceInterface $service,
    ): JsonResponse
    {
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

        $tenantId = $request->filled('tenant_id')
            ? $request->string('tenant_id')->toString()
            : null;

        $entityType = $request->filled('entity_type')
            ? PaymentEntityType::from($request->string('entity_type')->toString())
            : null;

        $payments = $service->paginate($pageRequest, $tenantId, $entityType);

        return PaymentResource::collection($payments)
            ->response()
            ->setStatusCode(Response::HTTP_OK)
        ;
    }
}
