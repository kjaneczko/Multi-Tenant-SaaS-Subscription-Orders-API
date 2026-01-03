<?php

namespace App\Http\Controllers\Payment;

use App\Application\Payment\Interface\PaymentQueryInterface;
use App\Application\Shared\Query\PageRequest;
use App\Domain\AuditLog\EntityType;
use App\Domain\Payment\PaymentEntityType;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ListPaymentController extends Controller
{
    public function __invoke(
        Request $request,
        PaymentQueryInterface $query,
    ): JsonResponse {
        $request->validate([
            'page' => 'sometimes|integer|min:1',
            'limit' => 'sometimes|integer|min:1|max:100',
            'tenant_id' => 'sometimes|uuid',
            'entity_type' => 'sometimes|string|min:1|max:255|in:'.implode(',', EntityType::values()),
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

        $payments = $query->paginate($pageRequest, $tenantId, $entityType);

        return PaymentResource::collection($payments)
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
